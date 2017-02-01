<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayersHasCouponsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('players_has_coupons', function(Blueprint $table)
		{
			$table->integer('players_id')->index('fk_players_has_coupons_players_idx');
			$table->integer('coupons_id')->index('fk_players_has_coupons_coupons1_idx');
			$table->primary(['players_id','coupons_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('players_has_coupons');
	}

}
