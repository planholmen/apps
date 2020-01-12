<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->integer('distance')->comment('Distance in kilometers');
            $table->text('from');
            $table->text('to');
            $table->text('purpose');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->boolean('transferred')->default(false);
            $table->boolean('posted')->default(false);
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
        Schema::dropIfExists('drives');
    }
}
