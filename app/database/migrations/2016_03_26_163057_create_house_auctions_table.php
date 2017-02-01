<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHouseAuctionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('house_auctions', function(Blueprint $table)
		{
			$table->integer('house_id')->unsigned();
			$table->boolean('world_id')->default(0);
			$table->integer('player_id')->index('player_id');
			$table->integer('bid')->unsigned()->default(0);
			$table->integer('limit')->unsigned()->default(0);
			$table->bigInteger('endtime')->unsigned()->default(0);
			$table->unique(['house_id','world_id'], 'house_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('house_auctions');
	}

}
