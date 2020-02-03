<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ph_id')->nullable();
            $table->bigInteger('user_id');
            $table->string('department');
            $table->string('activity');
            $table->double('amount');
            $table->string('creditor');
            $table->string('file_path')->nullable();
            $table->boolean('uploaded')->default(false);
            $table->boolean('posted')->default(false);
            $table->integer('approved')->default(0);
            $table->timestamp('approved_at')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
