<?php

class IntegracoesController extends \BaseController {

	public function getIndex()
	{
		return View::make('integracoes.index');
	}

	public function getDatabase()
	{
		$msg = array('Inicio da Configuração do Banco de Dados');

		if (Schema::hasTable('accounts'))
		{
			if (!Schema::hasColumn('accounts', 'premium_points_lost'))
			{
				Schema::table('accounts', function($table)
				{
					$table->integer('premium_points_lost')->default(0);
				});
				array_push($msg, "Criado a coluna 'premium_points_lost' na taleba 'accounts'.");
			}
			if (!Schema::hasColumn('accounts', 'remember_token'))
			{
				Schema::table('accounts', function($table)
				{
					$table->char('remember_token', 255);
				});
				array_push($msg, "Criado a coluna 'remember_token' na taleba 'accounts'.");
			}
			if (!Schema::hasColumn('accounts', 'created'))
			{
				Schema::table('accounts', function($table)
				{
					$table->integer('created')->nullable();
				});
				array_push($msg, "Criado a coluna 'created' na taleba 'accounts'.");
			}
			if (!Schema::hasColumn('accounts', 'nickname'))
			{
				Schema::table('accounts', function($table)
				{
					$table->char('nickname', 48)->nullable();
				});
				array_push($msg, "Criado a coluna 'nickname' na taleba 'accounts'.");
			}
			if (!Schema::hasColumn('accounts', 'viptime'))
			{
				Schema::table('accounts', function($table)
				{
					$table->integer('viptime')->default(0);
				});
				array_push($msg, "Criado a coluna 'viptime' na taleba 'accounts'.");
			}
			if (!Schema::hasColumn('accounts', 'avatar'))
			{
				Schema::table('accounts', function($table)
				{
					$table->char('avatar', 48)->nullable();
				});
				array_push($msg, "Criado a coluna 'avatar' na taleba 'accounts'.");
			}
			if (!Schema::hasColumn('accounts', 'group_id'))
			{
				Schema::table('accounts', function($table)
				{
					$table->integer('group_id')->default(1);
				});
				array_push($msg, "Criado a coluna 'group_id' na taleba 'accounts'.");
			}
		}

		if (Schema::hasTable('players'))
		{
			if (!Schema::hasColumn('players', 'world_id'))
			{
				Schema::table('players', function($table)
				{
					$table->boolean('world_id')->default(0);
				});
				array_push($msg, "Criado a coluna 'world_id'.");
			}
			if (!Schema::hasColumn('players', 'created'))
			{
				Schema::table('players', function($table)
				{
					$table->integer('created')->nullable();
				});
				array_push($msg, "Criado a coluna 'created'.");
			}
			if (!Schema::hasColumn('players', 'debug'))
			{
				Schema::table('players', function($table)
				{
					$table->integer('debug')->nullable();
				});
				array_push($msg, "Criado a coluna 'debug'.");
			}
			if (!Schema::hasColumn('players', 'online'))
			{
				Schema::table('players', function($table)
				{
					$table->boolean('online')->default(0)->index('online');
				});
				array_push($msg, "Criado a coluna 'online'.");
			}
		}

		if (!Schema::hasTable('cities'))
		{
			Schema::create('cities', function($table)
			{
				$table->integer('id', true);
				$table->string('name', 45);
				$table->integer('town_id')->default(1);
				$table->integer('posx')->default(0);
				$table->integer('posy')->default(0);
				$table->integer('posz')->default(0);
				$table->integer('account_id')->index('account_id');
				$table->timestamps();
				$table->softDeletes();
			});
			array_push($msg, 'Criado a tabela "cities".');
		}

		if (!Schema::hasTable('coupons'))
		{
			Schema::create('coupons', function($table)
			{
				$table->integer('id', true);
				$table->string('name');
				$table->string('code');
				$table->integer('type');
				$table->dateTime('validate');
				$table->integer('item')->default(0);
				$table->integer('count')->default(0);
				$table->integer('limit')->default(0);
				$table->integer('account_id');
				$table->timestamps();
				$table->softDeletes();
			});
			array_push($msg, 'Criado a tabela "coupons".');
		}

		if (!Schema::hasTable('accounts_has_coupons'))
		{
			Schema::create('accounts_has_coupons', function($table)
			{
				$table->integer('accounts_id')->index('fk_accounts_has_coupons_accounts1_idx');
				$table->integer('coupons_id')->index('fk_accounts_has_coupons_coupons1_idx');
				$table->primary(['accounts_id','coupons_id']);
			});
			array_push($msg, 'Criado a tabela "accounts_has_coupons".');
		}

		if (!Schema::hasTable('players_has_coupons'))
		{
			Schema::create('players_has_coupons', function($table)
			{
				$table->integer('players_id')->index('fk_players_has_coupons_players_idx');
				$table->integer('coupons_id')->index('fk_players_has_coupons_coupons1_idx');
				$table->primary(['players_id','coupons_id']);
			});
			array_push($msg, 'Criado a tabela "players_has_coupons".');
		}

		if (!Schema::hasTable('rates'))
		{
			Schema::create('rates', function($table)
			{
				$table->integer('id', true);
				$table->integer('rate')->default(0);
				$table->timestamps();
				$table->integer('account_id')->index('fk_rates_users1_idx');
			});
			array_push($msg, 'Criado a tabela "rates".');
		}

		if (!Schema::hasTable('medias'))
		{
			Schema::create('medias', function($table)
			{
				$table->integer('id', true);
				$table->string('path');
				$table->string('name');
				$table->string('type');
				$table->integer('capa')->default(0);
				$table->timestamps();
			});
			array_push($msg, 'Criado a tabela "medias".');
		}

		if (!Schema::hasTable('logs'))
		{
			Schema::create('logs', function($table)
			{
				$table->integer('id', true);
				$table->string('subject');
				$table->integer('type');
				$table->string('ip');
				$table->text('text', 65535)->nullable();
				$table->integer('account_id')->nullable();
				$table->integer('player_id')->nullable();
				$table->timestamps();
			});
			array_push($msg, 'Criado a tabela "logs".');
		}

		if (!Schema::hasTable('configuration'))
		{
			Schema::create('configuration', function($table)
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
				$table->string('moip_email')->nullable();
				$table->string('moip_key')->nullable();
				$table->string('moip_token')->nullable();
				$table->string('paypal_client_id')->nullable();
				$table->string('paypal_secret')->nullable();
				$table->integer('level')->default(0);
				$table->timestamps();
			});
			array_push($msg, 'Criado a tabela "configuration".');
		}

		if (!Schema::hasTable('configuration_has_media'))
		{
			Schema::create('configuration_has_media', function($table)
			{
				$table->integer('configuration_id')->index('fk_configuration_has_media_configuration1_idx_idx');
				$table->integer('media_id')->index('fk_configuration_has_media_media1_idx_idx');
			});
			array_push($msg, 'Criado a tabela "configuration_has_media".');
		}

		if (!Schema::hasTable('news'))
		{
			Schema::create('news', function($table)
			{
				$table->integer('id', true);
				$table->string('title');
				$table->string('slug');
				$table->text('description', 65535);
				$table->integer('featured')->nullable()->default(0);
				$table->text('tags', 65535)->nullable();
				$table->integer('gallery')->nullable()->default(0);
				$table->integer('views')->default(0);
				$table->string('meta_title');
				$table->string('meta_description');
				$table->string('meta_keywords');
				$table->timestamps();
				$table->integer('account_id')->default(0)->index('news_account_id_idx');
				$table->softDeletes();
			});
			array_push($msg, 'Criado a tabela "news".');
		}else{
			if(!Schema::hasColumn('news', 'slug'))
			{
				Schema::drop('comments');
				Schema::drop('news');
				array_push($msg, 'Deletando a antiga tabela "news".');

				Schema::create('news', function($table)
				{
					$table->integer('id', true);
					$table->string('title');
					$table->string('slug');
					$table->text('description', 65535);
					$table->integer('featured')->nullable()->default(0);
					$table->text('tags', 65535)->nullable();
					$table->integer('gallery')->nullable()->default(0);
					$table->integer('views')->default(0);
					$table->string('meta_title');
					$table->string('meta_description');
					$table->string('meta_keywords');
					$table->timestamps();
					$table->integer('account_id')->default(0)->index('news_account_id_idx');
					$table->softDeletes();
				});
				array_push($msg, 'Criado a nova tabela "news".');
			}
		}

		if (!Schema::hasTable('news_categories'))
		{
			Schema::create('news_categories', function($table)
			{
				$table->integer('id', true);
				$table->string('name');
				$table->string('slug');
				$table->string('meta_title');
				$table->string('meta_description');
				$table->string('meta_keywords');
				$table->timestamps();
				$table->integer('account_id')->index('news_categories_users_idx');
				$table->softDeletes();
			});
			array_push($msg, 'Criado a tabela "news_categories".');
		}

		if (!Schema::hasTable('news_has_news_categories'))
		{
			Schema::create('news_has_news_categories', function($table)
			{
				$table->integer('news_id')->index('fk_news_has_news_categories_news1_idx');
				$table->integer('news_categories_id')->index('fk_news_has_categories_news_categories1_idx');
				$table->primary(['news_id','news_categories_id']);
			});
			array_push($msg, 'Criado a tabela "news_has_news_categories".');
		}

		if (!Schema::hasTable('news_has_rates'))
		{
			Schema::create('news_has_rates', function($table)
			{
				$table->integer('news_id')->index('fk_news_has_rates_news1_idx');
				$table->integer('rates_id')->index('fk_news_has_rates_rates1_idx');
				$table->primary(['news_id','rates_id']);
			});
			array_push($msg, 'Criado a tabela "news_has_rates".');
		}

		if (!Schema::hasTable('news_has_media'))
		{
			Schema::create('news_has_media', function($table)
			{
				$table->integer('news_id')->index('fk_news_has_media_news1_idx');
				$table->integer('media_id')->index('fk_news_has_media_media1_idx');
				$table->primary(['news_id','media_id']);
			});
			array_push($msg, 'Criado a tabela "news_has_media".');
		}

		if (!Schema::hasTable('pages'))
		{
			Schema::create('pages', function($table)
			{
				$table->integer('id', true);
				$table->string('title');
				$table->string('slug');
				$table->text('body', 65535);
				$table->integer('gallery')->nullable()->default(0);
				$table->integer('views')->default(0);
				$table->string('meta_title');
				$table->string('meta_description');
				$table->string('meta_keywords');
				$table->timestamps();
				$table->integer('account_id')->index('pages_id_account_id_idx');
				$table->softDeletes();
			});
			array_push($msg, 'Criado a tabela "pages".');
		}

		if (!Schema::hasTable('pages_has_media'))
		{
			Schema::create('pages_has_media', function($table)
			{
				$table->integer('pages_id')->index('fk_pages_has_media_pages1_idx');
				$table->integer('media_id')->index('fk_pages_has_media_media1_idx');
				$table->primary(['pages_id','media_id']);
			});
			array_push($msg, 'Criado a tabela "pages_has_media".');
		}

		if (!Schema::hasTable('moip'))
		{
			Schema::create('moip', function($table)
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
			array_push($msg, 'Criado a tabela "moip".');
		}

		if (!Schema::hasTable('moip_cancellation'))
		{
			Schema::create('moip_cancellation', function($table)
			{
				$table->increments('id');
				$table->string('classification', 100)->nullable();
				$table->text('description', 16777215)->nullable();
				$table->text('message', 16777215)->nullable();
				$table->string('recovery', 50)->nullable();
				$table->timestamps();
				$table->softDeletes();
			});
			array_push($msg, 'Criado a tabela "moip_cancellation".');
		}

		if (!Schema::hasTable('moiptransacoes'))
		{
			Schema::create('moiptransacoes', function($table)
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
			array_push($msg, 'Criado a tabela "moiptransacoes".');
		}else{
			if (!Schema::hasColumn('moiptransacoes', 'status'))
			{
				Schema::table('moiptransacoes', function($table)
				{
					$table->boolean('status')->default(0)->index('status');
				});
				array_push($msg, 'Criado a coluna "status" na tabela "moiptransacoes".');
			}
		}

		if (!Schema::hasTable('pagsegurotransacoes'))
		{
			Schema::create('pagsegurotransacoes', function($table)
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
			array_push($msg, 'Criado a tabela "pagsegurotransacoes".');
		}else{
			if (!Schema::hasColumn('pagsegurotransacoes', 'status'))
			{
				Schema::table('pagsegurotransacoes', function($table)
				{
					$table->boolean('status')->default(0)->index('status');
				});
				array_push($msg, 'Criado a coluna "status" na tabela "pagsegurotransacoes".');
			}
		}
		
		if (!Schema::hasTable('paypaltransacoes'))
		{
			Schema::create('paypaltransacoes', function($table)
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
			array_push($msg, 'Criado a tabela "paypaltransacoes".');
		}else{
			if (!Schema::hasColumn('paypaltransacoes', 'status'))
			{
				Schema::table('paypaltransacoes', function($table)
				{
					$table->boolean('status')->default(0)->index('status');
				});
				array_push($msg, 'Criado a coluna "status" na tabela "paypaltransacoes".');
			}
		}

		if (!Schema::hasTable('shop_donation_history'))
		{
			Schema::create('shop_donation_history', function($table)
			{
				$table->integer('id', true);
				$table->string('method', 256);
				$table->string('receiver', 256);
				$table->string('buyer', 256);
				$table->string('account', 256);
				$table->integer('points');
				$table->integer('date');
				$table->string('transacaoID');
			});
			array_push($msg, 'Criado a tabela "shop_donation_history".');
		}else{
			if (!Schema::hasColumn('shop_donation_history', 'transacaoID'))
			{
				Schema::table('shop_donation_history', function($table)
				{
					$table->string('transacaoID');
				});
				array_push($msg, 'Criado a coluna "transacaoID" na tabela "shop_donation_history".');
			}
		}

		if (!Schema::hasTable('shop_offer'))
		{
			Schema::create('shop_offer', function($table)
			{
				$table->integer('id', true);
				$table->integer('points')->default(0);
				$table->integer('category')->default(1);
				$table->integer('type')->default(1);
				$table->integer('item')->default(0);
				$table->integer('count')->default(0);
				$table->text('description', 65535);
				$table->string('name');
				$table->integer('featured')->nullable()->default(0);
				$table->integer('points_off')->nullable()->default(0);
				$table->integer('stock')->nullable()->default(0);
				$table->softDeletes();
			});
			array_push($msg, 'Criado a tabela "shop_offer".');
		}else{
			if (!Schema::hasColumn('shop_offer', 'featured'))
			{
				Schema::table('shop_offer', function($table)
				{
					$table->string('featured');
				});
				array_push($msg, 'Criado a coluna "featured" na tabela "shop_offer".');
			}
			if (!Schema::hasColumn('shop_offer', 'points_off'))
			{
				Schema::table('shop_offer', function($table)
				{
					$table->string('points_off');
				});
				array_push($msg, 'Criado a coluna "points_off" na tabela "shop_offer".');
			}
			if (!Schema::hasColumn('shop_offer', 'stock'))
			{
				Schema::table('shop_offer', function($table)
				{
					$table->string('stock');
				});
				array_push($msg, 'Criado a coluna "stock" na tabela "shop_offer".');
			}
		}

		if (!Schema::hasTable('shop_offer_has_media'))
		{
			Schema::create('shop_offer_has_media', function($table)
			{
				$table->integer('shop_offer_id')->index('fk_shop_offer_has_media_pages1_idx_idx');
				$table->integer('media_id')->index('fk_shop_offer_has_media_media1_idx_idx');
			});
			array_push($msg, 'Criado a tabela "shop_offer_has_media".');
		}

		if (!Schema::hasTable('shop_history'))
		{
			Schema::create('shop_history', function($table)
			{
				$table->integer('id', true);
				$table->integer('product')->index('shop_history_shop_offer_id_idx');
				$table->string('session');
				$table->string('from')->index('shop_history_account_name_idx');
				$table->string('player')->index('shop_history_player_name_idx');
				$table->integer('date');
				$table->integer('processed')->default(0);
				$table->integer('points');
			});
			array_push($msg, 'Criado a tabela "shop_history".');
		}else{
			if (!Schema::hasColumn('shop_history', 'points'))
			{
				Schema::table('shop_history', function($table)
				{
					$table->string('points');
				});
				array_push($msg, 'Criado a coluna "points" na tabela "shop_history".');
			}
		}

		if (!Schema::hasTable('server_record'))
		{
			Schema::create('server_record', function($table)
			{
				$table->integer('record');
				$table->boolean('world_id')->default(0);
				$table->bigInteger('timestamp');
				$table->unique(['record','world_id','timestamp'], 'record');
			});
			array_push($msg, 'Criado a tabela "server_record".');
		}

		if (!Schema::hasTable('player_skills'))
		{
			Schema::create('player_skills', function($table)
			{
				$table->integer('player_id')->default(0)->index('player_id');
				$table->boolean('skillid')->default(0);
				$table->integer('value')->unsigned()->default(0);
				$table->integer('count')->unsigned()->default(0);
				$table->unique(['player_id','skillid'], 'player_id_2');
			});
			array_push($msg, 'Criado a tabela "player_skills".');
		}

		if (!Schema::hasTable('bans'))
		{
			Schema::create('bans', function($table)
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
			array_push($msg, 'Criado a tabela "bans".');
		}

		if (!Schema::hasTable('account_privacy'))
		{
			Schema::create('account_privacy', function($table)
			{
				$table->integer('account_id')->primary();
				$table->integer('email')->default(0);
			});
			array_push($msg, 'Criado a tabela "account_privacy".');
		}

		if (!Schema::hasTable('account_referal'))
		{
			Schema::create('account_referal', function($table)
			{
				$table->integer('account_id')->index('fk_account_has_referal_account1_idx');
				$table->integer('referal_account_id')->index('fk_account_has_referal_referal1_idx');
				$table->integer('date');
				$table->primary(['account_id','referal_account_id']);
			});
			array_push($msg, 'Criado a tabela "account_referal".');
		}

		if (!Schema::hasTable('referals'))
		{
			Schema::create('referals', function($table)
			{
				$table->integer('account_id');
				$table->string('name');
				$table->integer('status')->default(0);
				$table->timestamps();
			});
			array_push($msg, 'Criado a tabela "referals".');
		}


		array_push($msg, "Configuração concluida com sucesso!");

		return Redirect::back()->with('message', $msg);
	}

	public function getSenha()
	{
		$msg = array('Inicio da criptografia das senhas usando sha1.');

		$usuarios = User::all();

		if($usuarios->count()>0){
			if($usuarios->count()>1){
				array_push($msg, "Foram encontrados ".$usuarios->count()." usuários que teram suas senhas criptografadas.");
			}else{
				array_push($msg, "Foi encontrado somente ".$usuarios->count()." usuário que terá sua senha criptografada.");
			}
		}else{
			array_push($msg, "Não foi encontrado nenhum usuário no banco de dados.");
		}

		$total = 0;
		foreach ($usuarios as $key => $usuario) {
			$total++;
			$usuario->update(['password' => sha1($usuario->password)]);
		}
		array_push($msg, $total."/".$usuarios->count()." usuário(s) foram criptografados.");

		array_push($msg, "Criptografia finalizada!");

		return Redirect::back()->with('message', $msg);
	}

}