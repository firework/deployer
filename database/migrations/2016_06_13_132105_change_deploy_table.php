<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDeployTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE deploys CHANGE COLUMN status status ENUM('todo', 'success', 'error', 'canceled')");
        DB::statement("UPDATE deploys SET status='success' WHERE status='sucess'");

        Schema::table('deploys', function($table){
            $table->integer('user_id')->unsigned()->after('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('finished_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE deploys CHANGE COLUMN status status ENUM('todo', 'sucess', 'error', 'canceled')");
        DB::statement("UPDATE deploys SET status='sucess' WHERE status='success'");

        Schema::table('deploys', function ($table) {
            $table->dropColumn('finished_at');
            $table->dropForeign(['user_id']);
        });
    }
}
