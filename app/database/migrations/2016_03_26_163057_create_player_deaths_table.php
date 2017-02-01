<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerDeathsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('player_deaths', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('player_id')->index('player_id');
			$table->bigInteger('date')->unsigned()->index('date');
			$table->integer('level')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('player_deaths');
	}

}
