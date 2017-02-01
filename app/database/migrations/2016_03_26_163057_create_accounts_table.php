<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 32)->default('')->unique('name');
			$table->string('password');
			$table->integer('premdays')->default(0);
			$table->integer('lastday')->unsigned()->default(0);
			$table->string('email')->default('');
			$table->string('key', 128)->default('');
			$table->boolean('blocked')->default(0);
			$table->integer('warnings')->default(0);
			$table->integer('group_id')->default(1);
			$table->integer('page_access')->nullable();
			$table->integer('page_lastday')->nullable();
			$table->string('email_new')->nullable();
			$table->integer('email_new_time')->nullable();
			$table->string('rlname')->nullable();
			$table->string('location')->nullable();
			$table->integer('created')->nullable();
			$table->string('email_code')->nullable();
			$table->integer('next_email')->nullable();
			$table->integer('premium_points')->nullable();
			$table->integer('premium_points_lost')->default(0);
			$table->char('nickname', 48)->nullable();
			$table->char('avatar', 48)->nullable();
			$table->text('about_me', 65535)->nullable();
			$table->integer('viptime')->default(0);
			$table->string('remember_token', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('accounts');
	}

}
