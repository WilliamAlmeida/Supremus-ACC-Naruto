<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigurationHasMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('configuration_has_media', function(Blueprint $table)
		{
			$table->integer('configuration_id')->index('fk_configuration_has_media_configuration1_idx_idx');
			$table->integer('media_id')->index('fk_configuration_has_media_media1_idx_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('configuration_has_media');
	}

}
