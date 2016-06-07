<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('host');
            $table->string('username');
            $table->string('password');
            $table->string('path');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('deploy', function ($table){
            $table->dropColumn('server');
            $table->integer('server_id')->unsigned()->after('id');

            $table->foreign('server_id')->references('id')->on('servers');
        });

        Schema::rename('deploy', 'deploys');

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::rename('deploys', 'deploy');

        Schema::table('deploy', function ($table){
            $table->dropForeign(['server_id']);
            $table->text('server');
            $table->dropColumn('server_id');
        });

        Schema::drop('servers');
    }
}
