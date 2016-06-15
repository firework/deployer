<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeysToServer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->string('key');
            $table->string('keytext');
            $table->string('keyphrase');
            $table->integer('timeout')->default(30);
            $table->string('agent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->dropColumn('key');
            $table->dropColumn('keytext');
            $table->dropColumn('keyphrase');
            $table->dropColumn('timeout');
            $table->dropColumn('agent');
        });
    }
}
