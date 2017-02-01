<?php

class Helpers extends \BaseController {

	public static function registrarLog($dados = null){
		if($dados==null){
			return 0;
		}

		if(isset($dados['account_id']) && !empty($dados['account_id']) || isset($dados['player_id']) && !empty($dados['player_id'])){
			$request = Request::instance(); $request->setTrustedProxies(array('127.0.0.1')); $ip = $request->getClientIp();
			$dados['ip'] = $ip;
		}
		
		$registro = new Registro($dados);
		$registro->save();

		return 1;
	}

	public static function vip($dados, $acao = -1, $premdays = 0){
		$resultado = false;

		if($acao>0){
			$resultado = $dados->update(array('premdays' => ($premdays+$dados->premdays)));
		}else{
			$resultado = $dados->update(array('premdays' => 0));
		}
		return $resultado;
	}

	public static function emailNotificacao($dados = null){
		$resultado = 0;

		if(!empty($dados['subject']) && !empty($dados['mensagem'])){
			$configuracoes = Configuracao::first();

			if(isset($dados['to'])){
				if(empty($dados['to'])){
					$dados['to'] = $configuracoes->email;
				}
			}else{
				$dados = array_add($dados, 'to', $configuracoes->email);
			}
			if(isset($dados['toName'])){
				if(empty($dados['toName'])){
					$dados['toName'] = $configuracoes->title;
				}
			}else{
				$dados = array_add($dados, 'toName', $configuracoes->title);
			}
			if(isset($dados['from'])){
				if(empty($dados['from'])){
					$dados['from'] = 'no-reply@'.Request::getHost();
				}
			}else{
				$dados = array_add($dados, 'from', 'no-reply@'.Request::getHost());
			}

			$dados = array_add($dados, 'siteName', $configuracoes->title);
			$dados = array_add($dados, 'siteUrl', Request::getHost());
			
			if($configuracoes->midiaconfiguracao()->whereName('Banner')->first()){
				$dados = array_add($dados, 'siteBanner', $configuracoes->midiaconfiguracao()->whereName('Banner')->first()->path);
			}

			$dados = array_add($dados, 'mensagem_text', strip_tags($dados['mensagem']));
			$body = '
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 center-block">';
					if(isset($dados['siteBanner'])){
						$body .= HTML::image(str_replace('-original', '-banner', $dados['siteBanner']), $dados['siteName'], array('title' => $dados['siteName'], 'class' => 'img-responsive'));
					}
					$body .= '<p>'.$dados["mensagem"].'</p>';
					$body .= '
				</div>
			</div>
			';
			$dados['mensagem_html'] = $body;

			if(Config::get('mail.driver') == "sendgrid"){
				$resultado = Helpers::enviarSendGrid($dados);
			}else{
				Mail::send('emails.notificacao', $dados, function($message) use ($dados) {
					$message->to($dados['to'], $dados['toName'])->from($dados['from'], $dados['siteName'])->subject($dados['subject']);
				});

				$resultado = 1;
			}

		}
		return $resultado;
	}

	public static function enviarSendGrid($dados = null){
		if(!$dados){
			return 0;
		}

		$user = Config::get('services.sendgrid.username'); $pass = Config::get('services.sendgrid.password');
		if( !$user || empty($user) || !$pass || empty($pass) ){
			echo 'Precisa informar os dados do SendGrid no arquivo Services.'; die();
		}

		$url = 'https://api.sendgrid.com/';
		$json_string = array(
			'to' => array(
				$dados['to']
				),
			'category' => 'notificacao'
			);

		$params = array(
			'api_user'  => Config::get('services.sendgrid.username'),
			'api_key'   => Config::get('services.sendgrid.password'),
			'x-smtpapi' => json_encode($json_string),
			'to'        => $dados['to'],
			'subject'   => $dados['subject'],
			'html'      => $dados['mensagem_html'],
			'text'      => $dados['mensagem_text'],
			'from'      => $dados['from'],
			);

		$request =  $url.'api/mail.send.json';

		/*Generate curl request*/
		$session = curl_init($request);
		/*Tell curl to use HTTP POST*/
		curl_setopt ($session, CURLOPT_POST, true);
		/*Tell curl that this is the body of the POST*/
		curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
		/*Tell curl not to return headers, but do return the response*/
		curl_setopt($session, CURLOPT_HEADER, false);
		/*Tell PHP not to use SSLv3 (instead opting for TLS)*/
		/*curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);*/

		/*Turn off SSL*/
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);

		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		/*obtain response*/
		$response = curl_exec($session);
		curl_close($session);

		/*print everything out*/
		if(json_decode($response)->message == 'success'){ return 1; }else{ return 0; }
	}

	public static function ago($timestamp){
		if ( $timestamp <= 0 ) { return strtolower(Lang::get('content.an time ago')); }
		if ( $timestamp > time( ) ) { return strtolower(Lang::get('content.in future')); }

		$current = time( );
		$difference = $current - $timestamp;

		if ( $difference < 60 )
			$interval = 's';
		elseif ( $difference >= 60 and $difference < 60 * 60 )
			$interval = 'n';
		elseif ( $difference >= 60 * 60 and $difference < 60 * 60 * 24 )
			$interval = 'h';
		elseif ( $difference >= 60 * 60 * 24 and $difference < 60 * 60 * 24 * 7 )
			$interval = 'd';
		elseif ( $difference >= 60 * 60 * 24 * 7 and $difference < 60 * 60 * 24 * 30 )
			$interval = 'w';
		elseif ( $difference >= 60 * 60 * 24 * 30 and $difference < 60 * 60 * 24 * 365 )
			$interval = 'm';
		elseif ( $difference >= 60 * 60 * 24 * 365 )
			$interval = 'y';

		switch ( $interval )
		{
			case 'm':
			$months_difference = floor( $difference / 60 / 60 / 24 / 29 );
			while ( mktime( 
				date( 'H', $timestamp ), 
				date( 'i', $timestamp ), 
				date( 's', $timestamp ),
				date( 'n', $timestamp ) + $months_difference,
				date( 'j', $current ),
				date( 'Y', $timestamp )
				) < $current )
			{
				$months_difference++;
			}
			$amount = $months_difference;

			if ( $amount == 12 )
			{
				$amount--;
			}

			return $amount.' '.strtolower(Lang::choice('content.word calendar.month', $amount)).' '.strtolower(Lang::get('content.ago'));
			break;

			case 'y':
			$amount = floor( $difference / 60 / 60 / 24 / 365 );
			return $amount.' '.strtolower(Lang::choice('content.word calendar.year', $amount)).' '.strtolower(Lang::get('content.ago'));
			break;

			case 'd':
			$amount = floor( $difference / 60 / 60 / 24 );
			return $amount.' '.strtolower(Lang::choice('content.word calendar.day', $amount)).' '.strtolower(Lang::get('content.ago'));
			break;

			case 'w':
			$amount = floor( $difference / 60 / 60 / 24 / 7 );
			return $amount.' '.strtolower(Lang::choice('content.word calendar.week', $amount)).' '.strtolower(Lang::get('content.ago'));
			break;

			case 'h':
			$amount = floor( $difference / 60 / 60 );
			return $amount.' '.strtolower(Lang::choice('content.word calendar.time of day.hour', $amount)).' '.strtolower(Lang::get('content.ago'));
			break;

			case 'n':
			$amount = floor( $difference / 60 );
			return $amount.' '.strtolower(Lang::choice('content.word calendar.time of day.minute', $amount)).' '.strtolower(Lang::get('content.ago'));
			break;

			case 's':
			return $difference.' '.strtolower(Lang::choice('content.word calendar.time of day.second', $difference)).' '.strtolower(Lang::get('content.ago'));
			break;
		}
	}

	public static function formataData($data, $tipo = null){
		$semana = array(
			'Sun' => Lang::choice('content.word calendar.day of week.sunday', 1),
			'Mon' => Lang::choice('content.word calendar.day of week.monday', 1),
			'Tue' => Lang::choice('content.word calendar.day of week.tuesday', 1),
			'Wed' => Lang::choice('content.word calendar.day of week.wednesday', 1),
			'Thu' => Lang::choice('content.word calendar.day of week.thursday', 1),
			'Fri' => Lang::choice('content.word calendar.day of week.friday', 1),
			'Sat' => Lang::choice('content.word calendar.day of week.saturday', 1)
			);
		$mes_extenso = array(
			'Jan' => Lang::choice('content.word calendar.months of year.january', 1),
			'Feb' => Lang::choice('content.word calendar.months of year.february', 1),
			'Mar' => Lang::choice('content.word calendar.months of year.march', 1),
			'Apr' => Lang::choice('content.word calendar.months of year.april', 1),
			'May' => Lang::choice('content.word calendar.months of year.may', 1),
			'Jun' => Lang::choice('content.word calendar.months of year.june', 1),
			'Jul' => Lang::choice('content.word calendar.months of year.july', 1),
			'Aug' => Lang::choice('content.word calendar.months of year.august', 1),
			'Sep' => Lang::choice('content.word calendar.months of year.september', 1),
			'Oct' => Lang::choice('content.word calendar.months of year.october', 1),
			'Nov' => Lang::choice('content.word calendar.months of year.november', 1),
			'Dec' => Lang::choice('content.word calendar.months of year.december', 1)
			);

		if(!empty($data))
		{
			$data = date($data);
			$Semana = $semana[date('D', strtotime($data))];
			$Dia = date('d', strtotime($data));
			$Mes = $mes_extenso[date('M', strtotime($data))];
			$Ano = date('Y', strtotime($data));
			$Horario = date('h:i:s', strtotime($data));

			if($tipo==="data"){
				return $Mes.' '.$Dia.', '.$Ano;
			}elseif($tipo==="horario"){
				return $Horario;
			}elseif($tipo==="ano"){
				return $Ano;
			}else{
				return $Mes.' '.$Dia.', '.$Ano.' ás '.$Horario;
			}
		}else{
			return null;
		}
	}

	public static function view($id = null, $tipo = null)
	{
		if(isset($_COOKIE['Views'])){
			$valor = base64_decode($_COOKIE['Views']);
			$valores = explode(',', $valor);

			$verificacao = in_array($id, $valores);
			if(!$verificacao){
				array_push($valores, $id);
				$resultado = implode(',', $valores);
				$cookie = setcookie("Views", base64_encode($resultado), time()+3600*24*30*12*5);
				$view = true;
			}else{
				$view = false;
			}
		}else{
			$resultado = $id.',';
			$cookie = setcookie("Views", base64_encode($resultado), time()+3600*24*30*12*5);
			$view = true;
		}

		if($view){
			if($tipo==="noticias"){
				$noticia = Noticia::find($id)->increment('views', 1);
			}elseif($tipo==="produtos"){
				$produto = Produto::find($id)->increment('views', 1);
			}elseif($tipo==="paginas"){
				$pagina = Pagina::find($id)->increment('views', 1);
			}
		}
	}

	public static function nAuth(array $credentials = array(), $remember = false, $login = true){
		$verificacao = User::where('name', '=', $credentials['name'])->where('password', '=', sha1($credentials['password']))->first();
		if(isset($verificacao)){
			if($remember){
				$verificacao->update(['remember_token' => str_random(60)]);

				$valores = array(0 => $verificacao->name, 1 => $verificacao->remember_token);
				$resultado = implode(',', $valores);
				setcookie("account", base64_encode($resultado), time()+3600*24*30*12*5);
			}else{
				if(isset($_COOKIE['account'])){ setcookie("account", '', time()-1); }
				$verificacao->update(['remember_token' => str_random(60)]);
			}

			Auth::login($verificacao);
			return true;
		}else{
			return false;
		}
	}

	public static function arTiposRegistro(){
		$tipos = array();
		$tipos = array_add($tipos, 0, 'Sistema');
		$tipos = array_add($tipos, 1, 'Visitante');
		$tipos = array_add($tipos, 2, 'Usuário');
		$tipos = array_add($tipos, 3, 'Administrador');
		$tipos = array_add($tipos, 4, 'API');
		return $tipos;
	}

	public static function arTiposItem(){
		$tipos = array();
		$tipos = array_add($tipos, 0, 'Desconto');
		// $tipos = array_add($tipos, 1, 'Vale Presente');
		$tipos = array_add($tipos, 2, 'Dias Vip');
		return $tipos;
	}

	public static function arTiposPunicao(){
		$tipos = array();
		$tipos = array_add($tipos, 1, 'Banimento por IP');
		$tipos = array_add($tipos, 2, 'Uso de Nome Proibido');
		$tipos = array_add($tipos, 3, 'Banimento da Conta');
		$tipos = array_add($tipos, 4, 'Notação');
		$tipos = array_add($tipos, 5, 'Exclusão');
		return $tipos;
	}

	public static function arCategorias(){
		$categorias = array();
		$categorias = array_add($categorias, 1, 'Item');
		$categorias = array_add($categorias, 2, 'Vip');
		return $categorias;
	}

	public static function arMundos(){
		$mundos = array();
		$mundos = array_add($mundos, 0, 'Hi no Kuni');
		$mundos = array_add($mundos, 1, 'Mizu no Kuni');
		return $mundos;
	}

	public static function arVocacoes(){
		$vocacoes = array();
		$vocacoes = array_add($vocacoes, 1, 'Naruto');
		$vocacoes = array_add($vocacoes, 2, 'Sasuke');
		$vocacoes = array_add($vocacoes, 3, 'Sakura');
		return $vocacoes;
	}

	public static function arFiltroStatus(){
		$status = array();
		$status = array_add($status, 0, 'Off-line');
		$status = array_add($status, 1, 'Online');
		return $status;
	}

	public static function arFiltroRanking(){
		$filtros = array();
		$filtros = array_add($filtros, 1, Lang::choice('content.level', 1));
		$filtros = array_add($filtros, 8, Lang::get('content.fishing'));
		return $filtros;
	}

	public static function arFiltroImoveis(){
		$filtros = array();
		$filtros = array_add($filtros, 1, Lang::choice('content.price', 2));
		$filtros = array_add($filtros, 2, Lang::choice('content.bed', 2));
		return $filtros;
	}

	public static function arFiltroOnline(){
		$filtros = array();
		$filtros = array_add($filtros, 1, Lang::choice('content.level', 1));
		$filtros = array_add($filtros, 8, Lang::get('content.fishing'));
		return $filtros;
	}

	public static function arGrupo(){
		$grupo = array();
		$grupo = array_add($grupo, 1, 'Player');
		$grupo = array_add($grupo, 2, 'Player');
		$grupo = array_add($grupo, 3, 'Tutor');
		$grupo = array_add($grupo, 4, 'Senior Tutor');
		$grupo = array_add($grupo, 5, 'Game Master');
		$grupo = array_add($grupo, 6, 'God');
		return $grupo;
	}

	public static function arInsignias(){
		$insignias = array();
		$insignias = array_add($insignias, 0, array(
			'storage' => 30000,
			'value' => 1,
			'name' => 'Brock - Ginasio Pewter city - Insígnia de Rocha',
			'leader' => 'Brock',
			'gym' => 'Pewter',
			'badge' => 'Rocha',
			'img' => 'Rocha'
			));
		$insignias = array_add($insignias, 1, array(
			'storage' => 30001,
			'value' => 1,
			'name' => 'Misty - Ginasio Cerulean City - Insígnia de Cascata',
			'leader' => 'Misty',
			'gym' => 'Cerulean',
			'badge' => 'Cascata',
			'img' => 'Cascata'
			));
		$insignias = array_add($insignias, 2, array(
			'storage' => 30002,
			'value' => 1,
			'name' => 'Surge - Ginasio Vermilion City - Insígnia do Trovão',
			'leader' => 'Surge',
			'gym' => 'Vermilion',
			'badge' => 'Trovão',
			'img' => 'Trovao'
			));
		$insignias = array_add($insignias, 3, array(
			'storage' => 30003,
			'value' => 1,
			'name' => 'Sabrina - Ginasio Saffron City - Insígnia de Pântano',
			'leader' => 'Sabrina',
			'gym' => 'Saffron',
			'badge' => 'Pântano',
			'img' => 'Pantano'
			));
		$insignias = array_add($insignias, 4, array(
			'storage' => 30004,
			'value' => 1,
			'name' => 'Erika - Ginasio Celadon City - Insígnia de Arco - Íris',
			'leader' => 'Erika',
			'gym' => 'Celadon',
			'badge' => 'Arco - Íris',
			'img' => 'Arco-iris'
			));
		$insignias = array_add($insignias, 5, array(
			'storage' => 30005,
			'value' => 1,
			'name' => 'Koga - Ginasio Fuchsia City - Insígnia de Alma',
			'leader' => 'Koga',
			'gym' => 'Fuchsia',
			'badge' => 'Alma',
			'img' => 'Alma'
			));
		$insignias = array_add($insignias, 6, array(
			'storage' => 30006,
			'value' => 1,
			'name' => 'Blaine - Ginasio Cinnabar Island - Insígnia do Vulcão',
			'leader' => 'Blaine',
			'gym' => 'Cinnabar',
			'badge' => 'Vulcão',
			'img' => 'Vulcao'
			));
		$insignias = array_add($insignias, 7, array(
			'storage' => 30007,
			'value' => 1,
			'name' => 'Giovanni - Ginasio Viridian city - Insígnia de Terra',
			'leader' => 'Giovanni',
			'gym' => 'Viridian',
			'badge' => 'Terra',
			'img' => 'Terra'
			));
		return $insignias;
	}

	public static function arQuests(){
		$quests = array();
		$quests = array_add($quests, 0, array(
			'storage' => 31103,
			'value' => 1,
			'name' => 'Addon Quest',
			'description' => null,
			'localization' => null,
			'img' => null
			));
		$quests = array_add($quests, 1, array(
			'storage' => 95657,
			'value' => 1,
			'name' => 'Akatsuki',
			'description' => null,
			'localization' => null,
			'img' => null
			));
		return $quests;
	}

	public static function arAvatares(){
		$avatares = array();
		$avatares = array_add($avatares, 0, array(
			'name' => Lang::get('content.unknown'),
			'img' => '0'
			));
		$avatares = array_add($avatares, 1, array(
			'name' => 'Naruto',
			'img' => '1'
			));
		$avatares = array_add($avatares, 2, array(
			'name' => 'Kakashi',
			'img' => '2'
			));
		$avatares = array_add($avatares, 3, array(
			'name' => 'Neji',
			'img' => '3'
			));
		$avatares = array_add($avatares, 4, array(
			'name' => 'Sakura',
			'img' => '4'
			));
		$avatares = array_add($avatares, 5, array(
			'name' => 'Hinata',
			'img' => '5'
			));
		$avatares = array_add($avatares, 6, array(
			'name' => 'Rock Lee',
			'img' => '6'
			));
		$avatares = array_add($avatares, 7, array(
			'name' => 'Itachi',
			'img' => '7'
			));
		$avatares = array_add($avatares, 8, array(
			'name' => 'Tenten',
			'img' => '8'
			));
		$avatares = array_add($avatares, 9, array(
			'name' => 'Chouji',
			'img' => '9'
			));
		$avatares = array_add($avatares, 10, array(
			'name' => 'Gaara',
			'img' => '10'
			));
		$avatares = array_add($avatares, 11, array(
			'name' => 'Madara',
			'img' => '11'
			));
		$avatares = array_add($avatares, 12, array(
			'name' => 'Shikamaru',
			'img' => '12'
			));
		$avatares = array_add($avatares, 13, array(
			'name' => 'Sasuke',
			'img' => '13'
			));
		$avatares = array_add($avatares, 14, array(
			'name' => 'Killer Bee',
			'img' => '14'
			));
		$avatares = array_add($avatares, 15, array(
			'name' => 'Obito',
			'img' => '15'
			));
		$avatares = array_add($avatares, 16, array(
			'name' => 'Nagato',
			'img' => '16'
			));
		return $avatares;
	}

	public static function verificarReferencias($refered = null, $codigo = null, $action = null){
		$usuario = User::with('Player', 'AccountVipList', 'AccountReferal')->findOrfail($refered);
		if($action == null){
			$awards = array(
				'atual' => array(1 => 0, 2 => 0, 3 => 0, 4 => 0),
				'status' => array(
					1 => ($usuario->referencia()->whereName(1)->whereStatus(1)->exists()) ? 1 : 0,
					2 => ($usuario->referencia()->whereName(2)->whereStatus(1)->exists()) ? 1 : 0,
					3 => ($usuario->referencia()->whereName(3)->whereStatus(1)->exists()) ? 1 : 0,
					4 => ($usuario->referencia()->whereName(4)->whereStatus(1)->exists()) ? 1 : 0
					),
				'req' => array(1 => 50, 2 => 5, 3 => 5, 4 => 15)
				);

			if($usuario->accountreferal()->with('User', 'Referal')->exists()){
				foreach($usuario->accountreferal()->with('User', 'Referal')->get() as $conta)
				{
					if($conta->user->player()->where('level', '>=', 20)->exists()){ $awards['atual'][1] += 1; }
					if($conta->user->player()->where('level', '>=', 60)->exists()){ $awards['atual'][2] += 1; }
					if($conta->user->shopdonationhistory()->exists()){ $awards['atual'][3] += 1; }
					if($conta->user->shopdonationhistory()->exists()){ $awards['atual'][4] += 1; }
				}
			}
			return $awards;

		}elseif($action){
			$resultado = false;
			$personagens = 0;
			$contas = 0;

			if($codigo == 1){
				//50 pessoas level 20+ ganhara 1 dia vip
				foreach($usuario->accountreferal()->with('User', 'Referal')->get() as $conta)
				{
					if($conta->user->player()->where('level', '>=', 20)->exists()){ $personagens += 1; }
				}
				if($personagens >= 1){ $resultado = true; Helpers::vip($usuario, 1, 1); }

			}elseif($codigo == 2){
				//5 pessoas level 60+ ganhara 3 dias vip
				foreach($usuario->accountreferal()->with('User', 'Referal')->get() as $conta)
				{
					if($conta->user->player()->where('level', '>=', 60)->exists()){ $personagens += 1; }
				}
				if($personagens >= 5){ $resultado = true; Helpers::vip($usuario, 1, 3); }

			}elseif($codigo == 3){
				//5 amigos donataram, vip completa (30 dias)
				foreach($usuario->accountreferal()->with('User', 'Referal')->get() as $conta)
				{
					if($conta->user->shopdonationhistory()->exists()){ $contas += 1; }
				}
				if($contas >= 5){ $resultado = true; Helpers::vip($usuario, 1, 30); }

			}elseif($codigo == 4){
				//15 amigos donataram, depois ganhara outfit
				foreach($usuario->accountreferal()->with('User', 'Referal')->get() as $conta)
				{
					if($conta->user->shopdonationhistory()->exists()){ $contas += 1; }
				}
				if($contas >= 15){
					$resultado = true;
				}
			}

			return $resultado;
		}
	}

}