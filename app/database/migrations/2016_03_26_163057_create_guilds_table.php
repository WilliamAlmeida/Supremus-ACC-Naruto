<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuildsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('guilds', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->boolean('world_id')->default(0);
			$table->string('name');
			$table->integer('ownerid');
			$table->integer('creationdata');
			$table->string('motd');
			$table->unique(['name','world_id'], 'name');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('guilds');
	}

}
