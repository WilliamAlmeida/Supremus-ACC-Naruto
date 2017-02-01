<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerNamelocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('player_namelocks', function(Blueprint $table)
		{
			$table->integer('player_id')->default(0)->index('player_id');
			$table->string('name');
			$table->string('new_name');
			$table->bigInteger('date')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('player_namelocks');
	}

}
