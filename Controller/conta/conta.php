<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "26/04/2018",
		"CONTROLADOR": "Index",
		"LAST EDIT": "29/04/2018",
		"VERSION":"0.0.2"
	}
*/
class Conta {

	function __construct(){
	}

	function index(){

		/**
		** _controller(param1, param2, param3)
		** @param = nome layout/template - STRING
		** @param = nome controlador - STRING
		** @param = nome visão - STRING
		** @param = nome bigode de gato {{exemplo}} - ARRAY ou STRING
		**/
		$GOD = new Model_GOD;
		$dados = array();

		/*
		// UPDATE
		$dados['tabela'] = 'conta';
		$dados['acao'] = 'update';
		$dados['valor']  = array(
			'email' 		=> '123'
		);
		$dados['where']  = array(
			'email' 	 => 'mattheuszcabal@gmail.com',
			'senha' => 'asdg1124'
		);
		$dados['param'] = array(
			'emailNew'	=> $dados['valor']['email'],
			'email' 	=> $dados['where']['email'],
			'senha'		=> $dados['where']['senha']
		);*/

		/**/
		// INSERT
		/*$dados['tabela'] = 'conta';
		$dados['acao'] = 'insert';
		$dados['valor'] = array(
			'email' 		=> 'email@test.com',
			'senha' 		=> '1234',
			'data_criacao' 	=> $GOD->_hoje(),
			'hora_criacao' 	=> $GOD->_agora(),
		);
		$dados['param'] = array(
			'email' 		=> $dados['valor']['email'],
			'senha' 		=> $dados['valor']['senha'],
			'data_criacao' 	=> $dados['valor']['data_criacao'],
			'hora_criacao' 	=> $dados['valor']['hora_criacao'],
		);*/

		// DELETE
		/*$dados['tabela'] = 'conta';
		$dados['acao'] = 'delete';
		$dados['valor'] = array(
			'email' => 'novoemail@test.com',
			'senha' => '99999'
		);
		$dados['param'] = array(
			'email' => $dados['valor']['email'],
			'senha' => $dados['valor']['senha'],
		);*/


		$dados['tabela'] = 'conta';
		$dados['acao'] = 'select';
		$dados['valor'] = array(
			'email' => 'novoemail@test.com',
			'senha' => '99999'
		);
		$dados['select'] = array(
			'email',
			'senha',
			'data_criacao'
		);
		$dados['param'] = array(
			'email' => $dados['valor']['email'],
			'senha' => $dados['valor']['senha'],
		);

		$gerarSQL = $GOD->SQL($dados);

		new de($gerarSQL);
		$mustache = array(
			'{{header}}' => $GOD->headerHTML()
		);

		echo $GOD->_visao($GOD->_layout('conta', 'conta'), $mustache);
	}

	function criar(){

		$GOD = new Model_GOD;

		/* GERA TOKEN */
		$seguranca = $GOD->_token();
		$url = URL_SITE;

		/* SE EXISTER CONTA, SENHA E TOKEN VÁLIDO, ENTÃO FAÇA O CADASTRO */
		if(isset($_POST['email'], $_POST['token']) and !empty($_POST['email']) and $_POST['url'] == $url){

			$email = $GOD->basico($_POST['email']);
			$senha = $GOD->basico($_POST['senha']);
			$token = $GOD->basico($_POST['token']);

			/* COLOCA OS DADOS TRATATOS NUM ARRAY*/
			$dados['email'] = $email;
			$dados['senha'] = $senha;
			$dados['token'] = $token;

			/* COLOCA DOS DADOS NA FUNÇÃO PARA CRIAR CONTA */
			$GOD->newAccount($dados);
		}

		$mustache = array(
			'{{header}}' => $GOD->headerHTML(),
			'{{token}}' => $seguranca['token'],
			'{{url}}'	=> $seguranca['url']
		);

		echo $GOD->_visao($GOD->_layout('conta', 'criar'), $mustache);
	}

	function entrar(){

		$GOD = new Model_GOD;

		$mustache = array(
			'{{header}}' => $GOD->headerHTML()
		);

		echo $GOD->_visao($GOD->_layout('conta', 'entrar'), $mustache);
	}
}