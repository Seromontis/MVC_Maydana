<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "26/04/2018",
		"CONTROLADOR": "Index",
		"LAST EDIT": "07/06/2018",
		"VERSION":"0.0.7"
	}
*/
class Conta {

	public $_conexao;

	public $_consulta;

	public $_util;

	public $_cor;

	private $_push = false;

	function __construct(){

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);

		$this->_util = new Model_Pluggs_Utilit;

		$this->_cor = new Model_GOD;

		/* checkLogin é para páginas que precisam de login */
		$this->_func->checkLogin();

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}
	}

	function __destruct(){

		$this->_conexao = null;

		$this->_consulta = null;
	}

	function index(){

		/**
		** _controller(param1, param2, param3)
		** @param = nome layout/template - STRING
		** @param = nome controlador - STRING
		** @param = nome visão - STRING
		** @param = nome bithis->_core de gato {{exemplo}} - ARRAY ou STRING
		**/

		$mustache = array();

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('conta', 'conta'), $mustache);

		}else{

			echo $this->_cor->push('conta', 'conta', $mustache);
		}
	}

	function criar(){

		/* GERA TOKEN */
		$seguranca = $this->_cor->_token();
		$url = URL_SITE;

		/* SE EXISTER CONTA, SENHA E TOKEN VÁLIDO, ENTÃO FAÇA O CADASTRO */
		if(isset($_POST['email'], $_POST['token']) and !empty($_POST['email']) and !empty($_POST['nome']) and $_POST['url'] == $url){

			$email = $this->_util->basico($_POST['email']);
			$nome = $this->_util->basico($_POST['nome']);
			$senha = $this->_util->basico($_POST['senha']);
			$token = $this->_util->basico($_POST['token']);

			/* COLOCA OS DADOS TRATATOS NUM ARRAY*/
			$dados['email'] = $email;
			$dados['nome'] = $nome;
			$dados['senha'] = $senha;
			$dados['token'] = $token;

			/* COLOCA DOS DADOS NA FUNÇÃO PARA CRIAR CONTA */
			$criar = $this->_consulta->newAccount($dados);

			switch ($criar) {
				case 2:

					/* SQL FAIL */
					echo 'Algo de errado não está certo';
					break;

				case 3:

					/* ACCOUNT EXIST */
					echo 'Já existe um cadastro com esse e-mail';
					break;

				case 4:

					/* DADOS INVÁLIDOS */
					echo 'Preencha os dados conforme solicitado';
					break;
				
				default:

					/* CRIADO COM SUCESSO */
					echo 'Account created successfully';
					break;
			}

		}

		$mustache = array(
			'{{token}}' => $seguranca['token'],
			'{{url}}'	=> $seguranca['url']
		);

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('configuracao', 'configuracao'), $mustache);

		}else{

			echo $this->_cor->push('configuracao', 'configuracao', $mustache);
		}
	}

	function entrar(){

		/* GERA TOKEN */
		$seguranca = $this->_cor->_token();
		$url = URL_SITE;

		/* SE EXISTER CONTA, SENHA E TOKEN VÁLIDO, ENTÃO FAÇA O CADASTRO */
		if(isset($_POST['email']) and !empty($_POST['email']) and $_POST['url'] == $url){

			$email = $this->_util->basico($_POST['email']);
			$senha = $this->_util->basico($_POST['senha']);

			/* COLOCA OS DADOS TRATATOS NUM ARRAY*/
			$dados['email'] = $email;
			$dados['senha'] = $senha;

			/* COLOCA DOS DADOS NA FUNÇÃO PARA FAZER O LOGIN */
			$login = $this->_consulta->login($dados);

			switch ($login) {
				case 3:

					/* SENHA ERRADA*/
					echo 'E-mail ou senha incorreto!';
					break;

				case 4:

					/* DADOS INVÁLIDOS */
					echo 'Preencha os dados conforme solicitado';
					break;
				
				default:

					/* LOGADO COM SUCESSO */
					echo 'Login successfully';
					break;
			}
		}

		$mustache = array(
			'{{token}}' => $seguranca['token'],
			'{{url}}'	=> $seguranca['url']
		);

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('configuracao', 'configuracao'), $mustache);

		}else{

			echo $this->_cor->push('configuracao', 'configuracao', $mustache);
		}
	}

	function sair(){

		/* FALTA PASSAR UM TOKEN PARA SEGURANÇA.. */
		if(isset($_GET['usr']) AND is_numeric($_GET['usr'])){

			$return = $this->_consulta->logout($_GET['usr']);

			if($return == 2){
				header('location: /');
			}
		}
	}
}