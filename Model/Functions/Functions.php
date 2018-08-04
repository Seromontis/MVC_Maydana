<?
/*
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Functions",
	"LAST EDIT": "20/07/2018",
	"VERSION":"0.0.5"
*/

class Model_Functions_Functions {

	public $_conexao;

	public $_consulta;

	function __construct(){

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);
	}

	function __destruct(){

		$this->_conexao = null;

		$this->_consulta = null;

	}

	/* GERA TOKEN DE SEGURAÇA NOS FORMULÁRIO */
	function _TokenForm($formulario){

		$token = $this->HASH(md5(uniqid(microtime(), true)));

		$_SESSION[CLIENTE][$formulario.'_token'] = $token;

		return $token;
	}

	function _verificaToken($formulario, $send){

		/* $send = $_POST ou $_GET */
		if(!isset($_SESSION[CLIENTE][$formulario.'_token'])){
			return false;
		}

		if(!isset($send) or empty($send)){
			return false;
		}

		if(isset($_SESSION[CLIENTE][$formulario.'_token']) and $_SESSION[CLIENTE][$formulario.'_token'] !== $send){
			return false;
		}

		return true;
	}

	function _token(){

		$token = $this->HASH(md5(sha1(uniqid(time()))));
		$url = URL_SITE;

		$dados = array();
		if(isset($_SESSION['token']) and !empty($_SESSION['token'])){
			unset($_SESSION['token']);
		}

		if(isset($_SESSION['url'])){
			unset($_SESSION['url']);
		}

		$_SESSION['token'] = $token;
		$_SESSION['url'] = $url;
		$dados['token'] = $token;
		$dados['url'] = $url;
		
		return $dados;
	}

	/**
	** @see Cria o hash da senha, usando MD5 e SHA-1 + Salt
	** @param string
	** @return string
	**/

	function HASH($string){

		/**
		** @see NUNCA !!!!
		** @see NUNCA, JAMAIS, ALTERE O VALOR DA VARIÁVEL $salt
		**/
		$string = (string) $string;
		$salt = '31256578196*&%@#*(!$!+_%$(_+!%anpadfbahidpqwm,ksdpoqww[pqwṕqw[';

		return sha1(substr(md5($salt.$string), 5,25));
	}

	function checkPermission(){

		$id_cliente = null;
		$array = $_SESSION[CLIENTE]['login'] ?? array();
		foreach ($array as $id_conta => $info_conta){
			$id_cliente = $id_conta;
		}

		if($_SESSION[CLIENTE]['login'][$id_cliente]['acesso'] !== 6){

			/* Não tem permissão para acessar */
			header('location: /erro404');	
		};
	}

	function checkLogin(){

		/* SE NÃO TIVER SESSAO LOGIN, CAI FORA */
		if(!isset($_SESSION[CLIENTE]['login']) and empty($_SESSION[CLIENTE]['login'])){

			/* PRECISA ESTAR LOGADO PARA ENTRAR NO SISTEMA */
			header('location: /login');
		}

		/* SE EXISTIR A SESSÃO, VERIFICA SE EXISTE O DADO NO DB, SE NÃO TIVER LIMPA A SESSION */
		if(isset($_SESSION[CLIENTE]['login'])){

			$cliente = $this->_consulta->getInfoCliente('nome', key($_SESSION[CLIENTE]['login']));

			if($cliente === null){
				unset($_SESSION[CLIENTE]['login']);
			}
		}
	}
}