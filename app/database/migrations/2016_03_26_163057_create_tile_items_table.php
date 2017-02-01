<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTileItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tile_items', function(Blueprint $table)
		{
			$table->integer('tile_id')->unsigned();
			$table->boolean('world_id')->default(0);
			$table->integer('sid')->index('sid');
			$table->integer('pid')->default(0);
			$table->integer('itemtype');
			$table->integer('count')->default(0);
			$table->binary('attributes', 65535);
			$table->unique(['tile_id','world_id','sid'], 'tile_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tile_items');
	}

}
