<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuildRanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('guild_ranks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('guild_id')->index('guild_id');
			$table->string('name');
			$table->integer('level');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('guild_ranks');
	}

}
