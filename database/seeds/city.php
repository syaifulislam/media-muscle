<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class city extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            [
                'name' => 'Aceh'
            ],
            [
                'name' => 'Sumatera'
            ],
            [
                'name' => 'Sumatera Barat'
            ],
            [
                'name' => 'Riau'
            ],
            [
                'name' => 'Jambi'
            ],
            [
                'name' => 'Sumatera Selatan'
            ],
            [
                'name' => 'Lampung'
            ],
            [
                'name' => 'Kepulauan Bangka Belitung'
            ],
            [
                'name' => 'Kepulauan Riau'
            ],
            [
                'name' => 'Dki Jakarta'
            ],
            [
                'name' => 'Jawa Barat'
            ],
            [
                'name' => 'Jawa Tengah'
            ],
            [
                'name' => 'Di Yogyakarta'
            ],
            [
                'name' => 'Jawa Timur'
            ],
            [
                'name' => 'Banten'
            ],
            [
                'name' => 'Bali'
            ],
            [
                'name' => 'Nusa Tenggara Barat'
            ],
            [
                'name' => 'Nusa Tenggara Timur'
            ],
            [
                'name' => 'Kalimantan Barat'
            ],
            [
                'name' => 'Kalimantan Tengah'
            ],
            [
                'name' => 'Kalimantan Selatan'
            ],
            [
                'name' => 'Kalimantan Timur'
            ],
            [
                'name' => 'Kalimantan Utara'
            ],
            [
                'name' => 'Sulawesi Utara'
            ],
            [
                'name' => 'Sulawesi Tengah'
            ],
            [
                'name' => 'Sulawesi Selatan'
            ],
            [
                'name' => 'Sulawesi Tenggara'
            ],
            [
                'name' => 'Gorontalo'
            ],
            [
                'name' => 'Sulawesi Barat'
            ],
            [
                'name' => 'Maluku'
            ],
            [
                'name' => 'Maluku Utara'
            ],
            [
                'name' => 'Papua Barat'
            ],
            [
                'name' => 'Papua'
            ],
        ]);
    }
}
