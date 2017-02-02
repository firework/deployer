<?php

use Illuminate\Database\Seeder;
use App\Models\Server;

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
            'key' => '/home/vagrant/.ssh/id_rsa'
        ]);
    }
}
