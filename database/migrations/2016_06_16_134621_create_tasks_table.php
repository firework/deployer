<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('commands');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('deploys', function($table){
            $table->integer('task_id')->unsigned()->nullable();
            $table->foreign('task_id')->references('id')->on('tasks');
        });

        DB::statement("ALTER TABLE deploys CHANGE COLUMN status status ENUM('todo', 'success', 'error', 'canceled', 'running')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE deploys CHANGE COLUMN status status ENUM('todo', 'success', 'error', 'canceled')");

        Schema::table('deploys', function($table){
            $table->dropForeign(['task_id']);
            $table->dropColumn('task_id');
        });

        Schema::drop('tasks');
    }
}
