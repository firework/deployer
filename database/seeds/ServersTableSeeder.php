<?php

use Illuminate\Database\Seeder;
use App\Server;

class ServersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Server::create([
            'name' => 'Vagrant',
            'host' => 'localhost',
            'username' => 'vagrant',
            'password' => '',
            'path' => '/vagrant',
        ]);
    }
}
