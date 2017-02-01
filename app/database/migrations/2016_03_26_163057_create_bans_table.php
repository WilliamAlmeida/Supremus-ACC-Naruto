<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('type');
			$table->integer('value')->unsigned();
			$table->integer('param')->unsigned()->default(4294967295);
			$table->boolean('active')->default(1)->index('active');
			$table->integer('expires');
			$table->integer('added')->unsigned();
			$table->integer('admin_id')->unsigned()->default(0);
			$table->text('comment', 65535);
			$table->integer('reason')->unsigned()->default(0);
			$table->integer('action')->unsigned()->default(0);
			$table->string('statement')->default('');
			$table->index(['type','value'], 'type');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bans');
	}

}
