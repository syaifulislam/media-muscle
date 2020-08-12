<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiRegister;
use App\Client;
use App\City;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Mail;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;

class AuthApiController extends Controller
{

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        try{
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'code' => 400,
                    'message' => 'invalid_credentials'
                ], 400);
            }
        } catch (JWTException $e){
            return response()->json([
                'code' => 500,
                'message' => 'could_not_create_token'
            ], 500);
        }
        
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'token' => $token
        ],200);
    }

    public function register(Request $request){
        $checkData = Client::where('email',$request->get('email'))->first();
        if ($checkData){
            return response()->json([
                'code' => 400,
                'message' => 'Email has been registered'
            ],400);
        }
        if ($request->get('is_personal') === 1){
            $credentials = $request->except('is_personal');
            $credentials['isPersonal'] = 1;
            $credentials['password'] = Hash::make($request->get('password'));
            $client = Client::create($credentials);
        } else {
            $credentials = $request->except('is_personal');
            $credentials['isPersonal'] = 0;
            $credentials['password'] = Hash::make($request->get('password'));
            $client = Client::create($credentials);
        }
        $this->sendMail($client);
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ],200);
    }

    public function forgot_password(Request $request){
        $email = $request->get('email');
        $client = Client::where('email',$email)->first();
        if ($client == null){
            return response()->json([
                'code' => 404,
                'message' => 'Client not found!'
            ],404);
        }
        $this->sendMailForgot($client);
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ],200);
    }

    public function me(){
        $user = JWTAuth::parseToken()->authenticate();
        if ($user['isVerif'] == 0){
            return response()->json([
                'code' => 200,
                'message' => 'Verify email first!',
                'data' => $user
            ],200);
        }
        
        if ($user['status'] == 0){
            return response()->json([
                'code' => 404,
                'message' => 'Your account has been banned!'
            ],404);
        }
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $user
        ],200);
    }

    public function forgot_password_generate(Request $request){
        $token = urldecode($request->get('token'));
        $now = Carbon::now();
        try {
            $decrypted = decrypt($token);
        } catch (DecryptException $e) {
            return response()->json([
                'code' => 400,
                'message' => $e->getMessage()
            ],400);
        }
        $explodeToken = explode(';',$decrypted);
        $parsingDate = Carbon::parse($explodeToken[1]);
        $parsingId = (int)$explodeToken[0];
        if ($now <= $parsingDate){
            Client::where('id',$parsingId)->update(['password' => Hash::make($request->get('password'))]);
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ],200);
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Link expired'
            ],400);
        }
    }

    public function confirm_email(Request $request){
        $token = urldecode($request->get('token'));
        $now = Carbon::now();
        try {
            $decrypted = decrypt($token);
        } catch (DecryptException $e) {
            return response()->json([
                'code' => 400,
                'message' => $e->getMessage()
            ],400);
        }
        $explodeToken = explode(';',$decrypted);
        $parsingDate = Carbon::parse($explodeToken[1]);
        $parsingId = (int)$explodeToken[0];
        if ($now <= $parsingDate){
            Client::where('id',$parsingId)->update(['isVerif' => 1]);
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ],200);
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Link expired'
            ],400);
        }
    }

    public function helpMail(Request $request){
        $name = $request->get('name');
        $email = $request->get('email');
        $phone_number = $request->get('phone_number');
        $question = $request->get('question');
        $url = env('SLACK_WEBHOOK');
        $client = new \GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $body = [
            'text' => "Question received!!!
            - Name : $name 
            - Email : $email 
            - Phone Number : $phone_number 
            - Question : $question
            <mailto:".$email."?subject=Answer|Click here> to response the question!"
        ];
        $response = $client->request('POST', $url, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'json' => $body
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ],200);
    }

    private function sendMail($client){
        $id = $client['id'];
        $nowPlus2 = Carbon::now()->add(12, 'hour');
        $dateFormated = $nowPlus2->format('Y-m-d H:i:s');
        $concat = $id.';'.$dateFormated;
        $to_name = $client['name'];
        $to_email = $client['email'];
        $token = encrypt($concat);
        $data = [
            "url_action" => env('WEB_URL').'activatedAccount?token='.$token
        ];
        Mail::send('email.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Verify Account');
            $message->from(env('MAIL_FROM_ADDRESS'),'Media Muscle');
        });
        return $data;
    }

    private function sendMailForgot($client){
        $id = $client['id'];
        $nowPlus2 = Carbon::now()->add(2, 'hour');
        $dateFormated = $nowPlus2->format('Y-m-d H:i:s');
        $concat = $id.';'.$dateFormated;
        $to_name = $client['name'];
        $to_email = $client['email'];
        $token = encrypt($concat);
        $data = [
            "url_action" => env('WEB_URL').'forgotPassword?token='.$token
        ];
        Mail::send('email.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Reset Password');
            $message->from(env('MAIL_FROM_ADDRESS'),'Media Muscle');
        });
        return $data;
    }

    public function city(){
        $data = City::select(['id','name'])->orderBy('name','asc')->get();
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'token' => $data
        ],200);
    }

    public function updateProfileMember(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $body = $request->all();
        Client::where("id",$user->id)->update($body);
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ],200);
    }

    public function changePasswordMember(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $credentials = [
            'email' => $user->email,
            'password' => $request->get('current_password')
        ];
        $attempt = JWTAuth::attempt($credentials);
        if (!$attempt){
            return response()->json([
                'code' => 404,
                'message' => 'Current password not match'
            ],404);
        }
        $newPassword = Hash::make($request->get('new_password'));
        Client::where('id',$user->id)->update(['password' => $newPassword]);
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ],200);
    }
}
