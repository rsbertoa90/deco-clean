<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
class CreateEventsTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seminar_id')->unsigned();
            $table->foreign('seminar_id')->references('id')->on('seminars')->onDelete('cascade');
            $table->string('mode');
            $table->date('date');
            $table->string('hour')->default('12:00');
            $table->integer('quota')->nullable();
            $table->integer('price')->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')
                    ->on('cities')->onDelete('cascade');
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->text('comments')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('events');
    }
}
