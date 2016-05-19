<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeployTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deploy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('server');
            $table->string('branch');
            $table->enum('status', ['todo', 'sucess', 'error', 'canceled'])->default('todo');
            $table->timestamps();
        });

        Schema::create('deploy_output', function (Blueprint $table) {
            $table->integer('deploy_id')->unsigned();
            $table->text('output');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deploy');
        Schema::drop('deploy_output');
    }
}
