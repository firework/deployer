<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkServersTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_id')->unsigned()->index();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');

            $table->integer('server_id')->unsigned()->index();
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasks_servers');
    }
}
