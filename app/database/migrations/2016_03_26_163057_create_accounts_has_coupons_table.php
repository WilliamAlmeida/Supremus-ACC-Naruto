<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsHasCouponsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts_has_coupons', function(Blueprint $table)
		{
			$table->integer('accounts_id')->index('fk_accounts_has_coupons_accounts1_idx');
			$table->integer('coupons_id')->index('fk_accounts_has_coupons_coupons1_idx');
			$table->primary(['accounts_id','coupons_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('accounts_has_coupons');
	}

}
