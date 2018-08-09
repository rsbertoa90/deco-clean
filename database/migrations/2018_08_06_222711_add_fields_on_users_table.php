<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider')->default('local');
            $table->string('provider_id')->nullable();
            $table->string('avatar')->nullable();
             $table->integer('wallet')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn('provider');
            $table->dropColumn('provider_id');
            $table->dropColumn('avatar');
             $table->dropColumn('wallet');
        });
    }
}
