<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "31/06/2018",
		"CONTROLADOR": "Contato",
		"LAST EDIT": "01/06/2018",
		"VERSION":"0.0.1"
	}
*/

class Contato {
	
	public $_conexao;

	public $_consulta;

	public $_render;

	public $_func;

	function __construct(){

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);

		$this->_func = new Model_Functions_Functions;

		$this->_render = new Model_Functions_Render;
	}

	function __destruct(){

		$this->_conexao = null;

		$this->_consulta = null;

		$this->_func = null;

		$this->_render = null;
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
		$this->_func->checkLogin();
		/* PEGA OS DADOS DA PAGINA CONTATO NO BANCO DE DADOS */
		$pg = $this->_consulta->siteContato($_SESSION[CLIENTE]['login']);

		/* RENDER _ PREPARA OS DADOS */
		$pg = $this->_render->conteudo($pg);

		$redesociais = '';
		if(isset($pg['redesociais'])){

			foreach ($pg['redesociais'] as $key => $value){
				$redesociais .= '<ul><strong>'.$key.':</strong> '.$value.'</ul>';
			}
		}

		$contato = '';
		if(isset($pg['contato'])){

			foreach ($pg['contato'] as $key => $value){
				$contato .= '<ul><strong>'.$key.':</strong> '.$value.'</ul>';
			}
		}

		$mustache = array(
			'{{titulo}}' => $pg['conteudo']['titulo'],
			'{{subtitulo}}' => $pg['conteudo']['subtitulo'],
			'{{contato}}' => $contato,
			'{{redesociais}}' => $redesociais,
		);

		echo $GOD->_visao($GOD->_layout('contato', 'contato'), $mustache);
	}
}