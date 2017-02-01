<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePollVotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('poll_votes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('answer_id')->nullable()->index('answer_id');
			$table->integer('poll_id')->nullable()->index('poll_id');
			$table->integer('account_id')->index('account_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('poll_votes');
	}

}
