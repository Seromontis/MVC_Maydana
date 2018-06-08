<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "26/04/2018",
		"CONTROLADOR": "Login",
		"LAST EDIT": "07/06/2018",
		"VERSION":"0.0.7"
	}
*/
class Login {

	public $_conexao;

	public $_consulta;

	public $_util;

	public $_template = 'login';

	function __construct(){

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);

		$this->_util = new Model_Pluggs_Utilit;

		/* Function noLogin não permite entrar no controlador login com Login.. kk*/
		$this->_util->noLogin();
	}

	function __destruct(){

		$this->_conexao = null;

		$this->_consulta = null;

		$this->_template = null;
		
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

		/* GERA TOKEN */
		$seguranca = $GOD->_token();
		$url = URL_SITE;

		$mustache = array(
			'{{url}}'	=> $seguranca['url']
		);

		echo $GOD->_visao($GOD->_layout('login', 'login', $this->_template), $mustache);
	}

	function criar(){

		$GOD = new Model_GOD;

		/* GERA TOKEN */
		$seguranca = $GOD->_token();
		$url = URL_SITE;

		$mustache = array(
			'{{token}}' => $seguranca['token'],
			'{{url}}'	=> $seguranca['url']
		);

		echo $GOD->_visao($GOD->_layout('login', 'criar', $this->_template), $mustache);
	}

	function novo(){

		/* SE EXISTER CONTA, SENHA E TOKEN VÁLIDO, ENTÃO FAÇA O CADASTRO */
		if(isset($_POST['email'], $_POST['token']) and !empty($_POST['email']) and !empty($_POST['nome']) and $_POST['url'] == URL_SITE){

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
	}

	function entrar(){

		/* SE EXISTER CONTA, SENHA E TOKEN VÁLIDO, ENTÃO FAÇA O CADASTRO */
		if(isset($_POST['email']) and !empty($_POST['email']) and $_POST['url'] == URL_SITE){

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
					header('location: /');
					echo 'Login successfully';
					break;
			}
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