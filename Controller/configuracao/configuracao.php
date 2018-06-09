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
class Configuracao {

	public $_func;

	public $_conexao;

	public $_consulta;

	public $_render;

	public $_cor;

	private $_push = false;

	function __construct(){

		$this->_func = new Model_Functions_Functions;

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);

		$this->_render = new Model_Functions_Render;

		$this->_cor = new Model_GOD;

		/* checkLogin é para páginas que precisam de login */
		$this->_func->checkLogin();

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}
	}

	function index(){

		$configuracoes = $this->_consulta->getConfig($_SESSION[CLIENTE]['login']);

		$conf = $this->_render->getconfig($configuracoes);

		$mustache = array(
			'{{id_login}}' 	=> $_SESSION[CLIENTE]['login'],
			'{{configuracao}}' => $conf
		);

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('configuracao', 'configuracao'), $mustache);

		}else{

			echo $this->_cor->push('configuracao', 'configuracao', $mustache);
		}
	}
}