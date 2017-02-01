<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigurationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('configuration', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title');
			$table->string('description');
			$table->string('keywords');
			$table->string('email');
			$table->string('facebook')->nullable();
			$table->string('twitter')->nullable();
			$table->dateTime('founded')->nullable();
			$table->decimal('cost_points', 10)->nullable()->default(0.00);
			$table->string('pagseguro_email')->nullable();
			$table->string('pagseguro_token')->nullable();
			$table->integer('level')->default(0);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('configuration');
	}

}
