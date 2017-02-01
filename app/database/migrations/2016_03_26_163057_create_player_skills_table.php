<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerSkillsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('player_skills', function(Blueprint $table)
		{
			$table->integer('player_id')->default(0)->index('player_id');
			$table->boolean('skillid')->default(0);
			$table->integer('value')->unsigned()->default(0);
			$table->integer('count')->unsigned()->default(0);
			$table->unique(['player_id','skillid'], 'player_id_2');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('player_skills');
	}

}
