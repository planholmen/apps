<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CarLicensePlateMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        foreach (\App\User::all() as $user) {
            if ($user->license_plate != null && \App\Car::find($user->license_plate) == null) {
                \App\Car::create(['license_plate' => $user->license_plate, 'owner_id' => $user->id]);
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('license_plate');
        });

        Schema::table('drives', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->after('purpose');
            $table->foreign('car_id')->references('id')->on('cars')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
