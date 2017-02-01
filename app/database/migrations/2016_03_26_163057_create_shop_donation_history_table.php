<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopDonationHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_donation_history', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('method', 256);
			$table->string('receiver', 256);
			$table->string('buyer', 256);
			$table->string('account', 256);
			$table->integer('points');
			$table->integer('date');
			$table->string('transacaoID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_donation_history');
	}

}
