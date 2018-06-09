<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "09/04/2018",
		"CONTROLADOR": "Index",
		"LAST EDIT": "07/06/2018",
		"VERSION":"0.0.5"
	}
*/
class Index {

	public $_func;

	private $_cor;

	private $_push = false;

	function __construct(){

		$this->_func = new Model_Functions_Functions;
		/* checkLogin é para páginas que precisam de login */
		$this->_func->checkLogin();

		$this->_cor = new Model_GOD;

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}
	}

	function index(){

		/**
		** _controller(param1, param2, param3)
		** @param = nome layout/template - STRING
		** @param = nome controlador - STRING
		** @param = nome visão - STRING
		** @param = nome bigode de gato {{exemplo}} - ARRAY ou STRING
		**/


		$mustache = array(
			'{{id_login}}' 	=> $_SESSION[CLIENTE]['login']
		);

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('index', 'index'), $mustache);

		}else{

			echo $this->_cor->push('index', 'index');
		}
	}
}