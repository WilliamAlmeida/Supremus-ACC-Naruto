<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerViplistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('player_viplist', function(Blueprint $table)
		{
			$table->integer('player_id')->index('player_id');
			$table->integer('vip_id')->index('vip_id');
			$table->unique(['player_id','vip_id'], 'player_id_2');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('player_viplist');
	}

}
