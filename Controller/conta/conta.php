<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "26/04/2018",
		"CONTROLADOR": "Index",
		"LAST EDIT": "26/04/2018",
		"VERSION":"0.0.1"
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

		//new de($GOD->getPessoa(2));

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