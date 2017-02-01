<?php

class BansController extends \BaseController {
	public function getIndex()
	{
		$punicoes = Ban::with('User','Player')->paginate(15);

		$tipos = Helpers::arTiposPunicao();

		return View::make('punicoes.index', compact('punicoes', 'tipos'));
	}

	public function getAdicionar()
	{
		$tipos = array(2 => 'Uso de Nome Proibido', 3 => 'Banimento da Conta');
		$lista_contas = User::lists('name', 'id');
		$lista_personagens = Player::lists('name', 'id');

		return View::make('punicoes.create', compact('tipos', 'lista_contas', 'lista_personagens'));
	}

	public function postAdicionar()
	{
		$data = Input::all();

		$rules = array(
			'comment' => array('required','min:5')
			);

		if(Input::has('permanent')){
			if(!Input::has('expires')){
				$data = array_add($data, 'expires', -1);
			}else{
				$data['expires'] = -1;
			}
		}else{
			$rules = array_add($rules, 'expires', array('required','date'));
			$data['expires'] = $data['expires'].' '.$data['time'].':00';
		}

		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'punicao')->withInput();
		}

		$punicao = new Ban($data);
		
		if($data['type']==2){
			$msg = 'personagem '.Player::findOrFail($data['player'])->name;
			$punicao->value = $data['player'];
		}else{
			$msg = 'usuário '.User::findOrFail($data['account'])->name;
			$punicao->value = $data['account'];
		}

		$punicao->admin_id = Auth::user()->id;
		$punicao->save();

		Helpers::registrarLog($dados = array(
			'subject' => 'Nova Punição Dada.',
			'text' => ('Usuário '.Auth::user()->name.' puniu o '.((isset($msg)) ? $msg : 'Desconhecido').'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::to('painel/punicoes');
	}

	public function getEditar($id = null)
	{
		$punicao = Ban::with('User','Player')->findOrFail($id);

		$tipos = Helpers::arTiposPunicao();

		return View::make('punicoes.edit', compact('punicao', 'tipos'));
	}

	public function postEditar($id)
	{
		$punicao = Ban::findOrFail($id);

		$data = Input::all();

		$rules = array(
			'comment' => array('required','min:5')
			);

		if(Input::has('permanent')){
			if(!Input::has('expires')){
				$data = array_add($data, 'expires', -1);
			}else{
				$data['expires'] = -1;
			}
		}else{
			$rules = array_add($rules, 'expires', array('required','date'));
			$data['expires'] = $data['expires'].' '.$data['time'].':00';
		}

		$validator = Validator::make($data, $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'punicao')->withInput();
		}

		if(!Input::has('permanent')){ $data['expires'] = strtotime($data['expires']); }

		if($punicao->type==2){
			$msg = 'personagem '.$punicao->player->name;
		}elseif($punicao->type==3){
			$msg = 'usuário '.$punicao->user->name;
		}elseif($punicao->type==1){
			$msg = 'IP '.$punicao->value;
		}else{
			$msg = $punicao->value;
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Edição de Punição.',
			'text' => ('Usuário '.Auth::user()->name.' editou informações da punição do '.$msg.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		$punicao->update($data);

		return Redirect::to('painel/punicoes/editar/'.$id)->with('message', 'Atualização realizada com sucesso!');
	}

	public function getDeletar($id)
	{
		$punicao = Ban::with('User','Player')->findOrFail($id);

		if($punicao->type==2){
			$msg = 'personagem '.$punicao->player->name;
		}elseif($punicao->type==3){
			$msg = 'usuário '.$punicao->user->name;
		}elseif($punicao->type==1){
			$msg = 'IP '.$punicao->value;
		}else{
			$msg = $punicao->value;
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Remoção de Punição.',
			'text' => ('Usuário '.Auth::user()->name.' deletou a punição de '.$msg.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		Ban::destroy($id);

		return Redirect::to('painel/punicoes')->with('message', 'Deletado com sucesso!');
	}
}
