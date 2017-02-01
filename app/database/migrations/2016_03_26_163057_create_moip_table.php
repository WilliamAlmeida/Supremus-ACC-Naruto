<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMoipTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moip', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('receiver', 50)->default('williamconceicaoalmeida@outlook.com');
			$table->string('key', 40)->default('ABABABABABABABABABABABABABABABABABABABAB');
			$table->string('token', 32)->default('01010101010101010101010101010101');
			$table->boolean('environment')->default(0);
			$table->boolean('validate')->default(0);
			$table->string('reason')->default('Package Moip');
			$table->string('expiration')->default('3');
			$table->boolean('workingDays')->default(0);
			$table->string('firstLine');
			$table->string('secondLine');
			$table->string('lastLine');
			$table->string('uriLogo');
			$table->string('url_return');
			$table->string('url_notification');
			$table->boolean('billet')->default(1);
			$table->boolean('financing')->default(1);
			$table->boolean('debit')->default(1);
			$table->boolean('creditCard')->default(1);
			$table->boolean('debitCard')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('moip');
	}

}
