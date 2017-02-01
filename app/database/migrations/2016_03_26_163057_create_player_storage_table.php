<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerStorageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('player_storage', function(Blueprint $table)
		{
			$table->integer('player_id')->default(0)->index('player_id');
			$table->integer('key')->unsigned()->default(0);
			$table->string('value')->default('0');
			$table->unique(['player_id','key'], 'player_id_2');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('player_storage');
	}

}
