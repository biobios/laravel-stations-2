<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddUserRemoveNameEmailInReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            //
            $table->foreignId('user_id')->constrained();
        });

        //　データの移行
        $reservations = DB::table('reservations')->get();
        foreach ($reservations as $reservation){
            $user = DB::table('users')->where('email', $reservation->email)->first();
            if($user){
                DB::table('reservations')->where('id', $reservation->id)->update(['user_id' => $user->id]);
            }else{
                $user = DB::table('users')->insertGetId(['name' => $reservation->name, 'email' => $reservation->email, 'password' => '']);
                DB::table('reservations')->where('id', $reservation->id)->update(['user_id' => $user]);
            }
        }

        Schema::table('reservations', function (Blueprint $table) {
            //
            $table->dropColumn('name');
            $table->dropColumn('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            //
            $table->string('name');
            $table->string('email');
        });

        // データの移行
        $reservations = DB::table('reservations')->get();
        foreach ($reservations as $reservation){
            $user = DB::table('users')->where('id', $reservation->user_id)->first();
            DB::table('reservations')->where('id', $reservation->id)->update(['name' => $user->name, 'email' => $user->email]);
        }

        Schema::table('reservations', function (Blueprint $table) {
            //
            $table->dropForeign(['user_id']);
        });
    }
}
