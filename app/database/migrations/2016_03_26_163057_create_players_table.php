<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('players', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->boolean('world_id')->default(0);
			$table->integer('group_id')->default(1)->index('group_id');
			$table->integer('account_id')->default(0)->index('account_id');
			$table->integer('level')->default(1);
			$table->integer('vocation')->default(0);
			$table->integer('health')->default(150);
			$table->integer('healthmax')->default(150);
			$table->bigInteger('experience')->default(0);
			$table->integer('lookbody')->default(0);
			$table->integer('lookfeet')->default(0);
			$table->integer('lookhead')->default(0);
			$table->integer('looklegs')->default(0);
			$table->integer('looktype')->default(136);
			$table->integer('lookaddons')->default(0);
			$table->integer('maglevel')->default(0);
			$table->integer('mana')->default(0);
			$table->integer('manamax')->default(0);
			$table->integer('manaspent')->default(0);
			$table->integer('soul')->unsigned()->default(0);
			$table->integer('town_id')->default(0);
			$table->integer('posx')->default(0);
			$table->integer('posy')->default(0);
			$table->integer('posz')->default(0);
			$table->binary('conditions', 65535);
			$table->integer('cap')->default(0);
			$table->integer('sex')->default(0);
			$table->bigInteger('lastlogin')->unsigned()->default(0);
			$table->integer('lastip')->unsigned()->default(0);
			$table->boolean('save')->default(1);
			$table->boolean('skull')->default(0);
			$table->integer('skulltime')->default(0);
			$table->integer('rank_id')->default(0);
			$table->string('guildnick')->default('');
			$table->bigInteger('lastlogout')->unsigned()->default(0);
			$table->boolean('blessings')->default(0);
			$table->bigInteger('balance')->default(0);
			$table->bigInteger('stamina')->default(151200000);
			$table->integer('direction')->default(2);
			$table->integer('loss_experience')->default(100);
			$table->integer('loss_mana')->default(100);
			$table->integer('loss_skills')->default(100);
			$table->integer('loss_containers')->default(100);
			$table->integer('loss_items')->default(100);
			$table->integer('premend')->default(0);
			$table->boolean('online')->default(0)->index('online');
			$table->integer('marriage')->unsigned()->default(0);
			$table->integer('promotion')->default(0);
			$table->boolean('deleted')->default(0)->index('deleted');
			$table->string('description')->default('');
			$table->string('old_name')->nullable();
			$table->integer('hide_char')->nullable();
			$table->integer('worldtransfer')->nullable();
			$table->integer('created')->nullable();
			$table->integer('nick_verify')->nullable();
			$table->text('comment', 65535)->nullable();
			$table->integer('debug')->nullable();
			$table->unique(['name','deleted'], 'name');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('players');
	}

}
