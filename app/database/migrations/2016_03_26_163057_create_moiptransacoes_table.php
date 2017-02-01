<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMoiptransacoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moiptransacoes', function(Blueprint $table)
		{
			$table->string('TransacaoID', 36);
			$table->string('VendedorEmail', 200);
			$table->string('Referencia', 200)->nullable()->index('Referencia');
			$table->char('TipoFrete', 2)->nullable();
			$table->decimal('ValorFrete', 10)->nullable();
			$table->decimal('Extras', 10)->nullable();
			$table->text('Anotacao', 65535)->nullable();
			$table->string('TipoPagamento', 50);
			$table->string('StatusTransacao', 50);
			$table->string('CliNome', 200);
			$table->string('CliEmail', 200);
			$table->string('CliEndereco', 200);
			$table->string('CliNumero', 10)->nullable();
			$table->string('CliComplemento', 100)->nullable();
			$table->string('CliBairro', 100);
			$table->string('CliCidade', 100);
			$table->char('CliEstado', 2);
			$table->string('CliCEP', 9);
			$table->string('CliTelefone', 14)->nullable();
			$table->integer('NumItens');
			$table->dateTime('Data');
			$table->boolean('status')->default(0)->index('status');
			$table->unique(['TransacaoID','StatusTransacao'], 'TransacaoID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('moiptransacoes');
	}

}
