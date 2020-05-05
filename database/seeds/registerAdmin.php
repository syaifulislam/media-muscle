<?php

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class registerAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $credentials = [
            'email'    => 'admin.mm@gmail.com',
            'password' => 'password',
            'first_name' => 'Super',
            'last_name' => 'Admin'
        ];
        $user = Sentinel::register($credentials);
        
    }
}
