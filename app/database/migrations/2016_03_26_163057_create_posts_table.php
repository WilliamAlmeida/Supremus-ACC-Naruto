<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title', 120)->nullable();
			$table->text('text', 65535)->nullable();
			$table->integer('time')->nullable();
			$table->string('author', 64)->nullable();
			$table->integer('board_id')->nullable()->index('board_id');
			$table->integer('thread_id')->nullable()->index('thread_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
