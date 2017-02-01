<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuildInvitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('guild_invites', function(Blueprint $table)
		{
			$table->integer('player_id')->default(0);
			$table->integer('guild_id')->default(0)->index('guild_id');
			$table->unique(['player_id','guild_id'], 'player_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('guild_invites');
	}

}
