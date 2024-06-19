<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'name' => 'Alvaro Villanueva',
            'email' => 'alva.dev@gmail.com',
            'phone' => '985623548',
            'address' => 'JR. Pira 201',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);

        DB::table('clients')->insert([
            'name' => 'Dulce Villanueva',
            'email' => 'dulce@gmail.com',
            'phone' => '987489521',
            'address' => 'JR. Pira 201',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);

        DB::table('clients')->insert([
            'name' => 'Jessica Barreto',
            'email' => 'jessica@gmail.com',
            'phone' => '995689157',
            'address' => 'JR. Pira 201',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);
    }
}
