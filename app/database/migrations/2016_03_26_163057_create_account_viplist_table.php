<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountViplistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_viplist', function(Blueprint $table)
		{
			$table->integer('account_id')->index('account_id');
			$table->boolean('world_id')->default(0)->index('world_id');
			$table->integer('player_id')->index('player_id');
			$table->unique(['account_id','player_id'], 'account_id_2');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('account_viplist');
	}

}
