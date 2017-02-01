<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_history', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('product')->index('shop_history_shop_offer_id_idx');
			$table->string('session');
			$table->string('from')->index('shop_history_account_name_idx');
			$table->string('player')->index('shop_history_player_name_idx');
			$table->integer('date');
			$table->integer('processed')->default(0);
			$table->integer('points');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_history');
	}

}
