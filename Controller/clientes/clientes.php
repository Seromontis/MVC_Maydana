<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "07/06/2018",
		"CONTROLADOR": "Configuracao",
		"LAST EDIT": "07/06/2018",
		"VERSION":"0.0.1"
	}
*/
class Clientes {

	public $_func;

	public $_conexao;

	public $_consulta;

	public $_render;

	public $_nucleo;

	function __construct(){

		$this->_func = new Model_Functions_Functions;

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);

		$this->_render = new Model_Functions_Render;

		$this->_nucleo = new Model_GOD;

	}

	function index(){

		/* checkLogin é para páginas que precisam de login */
		$this->_func->checkLogin();

		$configuracoes = $this->_consulta->getConfig($_SESSION[CLIENTE]['login']);

		$conf = $this->_render->getconfig($configuracoes);

		$mustache = array(
			'{{id_login}}' 	=> $_SESSION[CLIENTE]['login']
		);

		echo $this->_nucleo->_visao($this->_nucleo->_layout('clientes', 'clientes'), $mustache);
	}
}