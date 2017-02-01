<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountReferalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_referal', function(Blueprint $table)
		{
			$table->integer('account_id')->index('fk_account_has_referal_account1_idx');
			$table->integer('referal_account_id')->index('fk_account_has_referal_referal1_idx');
			$table->integer('date');
			$table->primary(['account_id','referal_account_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('account_referal');
	}

}
