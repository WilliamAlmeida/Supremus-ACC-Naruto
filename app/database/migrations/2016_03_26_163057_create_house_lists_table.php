<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHouseListsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('house_lists', function(Blueprint $table)
		{
			$table->integer('house_id')->unsigned();
			$table->boolean('world_id')->default(0);
			$table->integer('listid');
			$table->text('list', 65535);
			$table->unique(['house_id','world_id','listid'], 'house_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('house_lists');
	}

}
