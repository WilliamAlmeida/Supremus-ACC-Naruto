<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('from')->nullable()->index('from');
			$table->integer('to')->nullable()->index('to');
			$table->string('title', 120)->nullable();
			$table->text('text')->nullable();
			$table->integer('time')->nullable();
			$table->boolean('delete_from')->nullable();
			$table->boolean('delete_to')->nullable();
			$table->boolean('unread')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('messages');
	}

}
