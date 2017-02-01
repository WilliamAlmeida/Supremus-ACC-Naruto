<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBugtrackerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bugtracker', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('category');
			$table->integer('time')->nullable();
			$table->integer('author')->index('author');
			$table->text('text', 65535)->nullable();
			$table->string('title', 120)->nullable();
			$table->boolean('done')->nullable();
			$table->boolean('priority')->nullable();
			$table->boolean('closed')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bugtracker');
	}

}
