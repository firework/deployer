<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slack_integration', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('webhook');
            $table->string('channel');
            $table->string('botname');
            $table->string('icon');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('integration_server', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slack_id')->unsigned()->index();
            $table->foreign('slack_id')->references('id')->on('slack_integration')->onDelete('cascade');

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
        Schema::drop('integration_server');
        Schema::drop('slack_integration');
    }
}
