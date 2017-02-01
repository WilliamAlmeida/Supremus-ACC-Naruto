<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('player_items', function(Blueprint $table)
		{
			$table->integer('player_id')->default(0)->index('player_id');
			$table->integer('pid')->default(0);
			$table->integer('sid')->default(0);
			$table->integer('itemtype')->default(0);
			$table->integer('count')->default(0);
			$table->binary('attributes', 65535);
			$table->unique(['player_id','sid'], 'player_id_2');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('player_items');
	}

}
