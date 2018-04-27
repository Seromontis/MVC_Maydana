<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "09/04/2018",
		"CONTROLADOR": "Index",
		"LAST EDIT": "09/04/2018",
		"VERSION":"0.0.2"
	}
*/
class Index {

	function __construct(){

		if(!isset($_SESSION['login']) and empty($_SESSION['login'])){

			/* PRECISA ESTAR LOGADO PARA ENTRAR NO SISTEMA */
			header('location: /conta');
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
		$GOD = new Model_GOD;

		//new de($GOD->getPessoa(2));

		$mustache = array(
			'{{header}}' => $GOD->headerHTML()
		);

		echo $GOD->_visao($GOD->_layout('index', 'index'), $mustache);
	}
}