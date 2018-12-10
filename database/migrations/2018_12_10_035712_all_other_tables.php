<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllOtherTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wallets_admin', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('pool', 32);
            $table->string('balance', 64);
            $table->string('timestamp', 64);
        });


        Schema::create('withdrawals', function (Blueprint $table) {
            $table->increments('ID');
            $table->smallInteger('user_ID');
            $table->string('amount', 32);
            $table->string('address', 64);
            $table->string('created', 32);
            $table->string('processed', 32);
            $table->string('result', 640);
        });


        Schema::create('nimbus', function (Blueprint $table) {
            $table->increments('ID');
            $table->mediumInteger('block');
            $table->mediumInteger('amount');
        });


        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('nimi_id');
            $table->smallInteger('user_id');
            $table->string('type', 64);
            $table->string('item', 64);
            $table->smallInteger('available')->default(0);
            $table->smallInteger('used')->default(0);
            $table->smallInteger('received')->default(0);
            $table->timestamp('last_used')->nullable();
            $table->timestamp('last_received')->nullable();
        });


        Schema::create('deadlist', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('user_id');
            $table->string('nimi_name');
            $table->string('nimi_points', 64);
            $table->string('nimi_value', 64);
            $table->string('timestamp', 64);
            $table->string('nimi_born', 64);
            $table->smallInteger('a')->default(0);
            $table->smallInteger('b')->default(0);
            $table->integer('food_eaten');
        });


        Schema::create('airdrop', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('amount', 64);
            $table->string('html');
            $table->string('timestamp', 64);
        });


        Schema::create('nimipets', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('user_id');
            $table->string('nimi_name', 64);
            $table->decimal('nimi_points', 64, 5)->default(0);
            $table->decimal('nimi_value', 64, 5)->default(0);
            $table->smallInteger('nimi_position')->default(0);
            $table->string('nimi_state', 32);
            $table->string('nimi_meta', 640);
            $table->timestamp('nimi_lastfed')->nullable();
            $table->string('nimi_price', 16);
            $table->string('nimi_msg', 600);
            $table->integer('food_eaten')->default(0);
            $table->timestamp('food_started')->nullable();
            $table->integer('food_progress')->default(0);
            $table->string('food_status', 32);
            $table->smallInteger('food_today')->default(0);
            $table->string('nimi_slug', 64);
            $table->timestamp('nimi_born')->nullable();
            $table->string('nimi_style', 640)->default('{\"color1\":\"#ff7b1c\",\"color2\":\"#ff7b1c\",\"color3\":\"#ff7b1c\",\"x1\":\"0%\",\"x2\":\"100%\",\"y1\":\"0%\",\"y2\":\"0%\",\"skin_url\":\"undefined\"}');
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
