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

	function __construct(){

		$this->_func = new Model_Functions_Functions;
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
		/* checkLogin é para páginas que precisam de login */
		$this->_func->checkLogin();

		$mustache = array(
			'{{id_login}}' 	=> $_SESSION[CLIENTE]['login']
		);

		echo $GOD->_visao($GOD->_layout('index', 'index'), $mustache);
	}
}