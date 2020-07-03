<?php

use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_usuario')->insert([
            'email' => 'samuel.scoelho@gmail.com',
            'username' => 'samuca',
            'password' => bcrypt('samuca')
        ]);
    }
}
