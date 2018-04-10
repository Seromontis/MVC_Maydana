<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "09/04/2018",
		"CONTROLADOR": "Erro 404",
		"LAST EDIT": "09/04/2018",
		"VERSION":"0.0.1"
	}
*/
class maydana {

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


		$define = '';
		$mustache = array(
			'{{header}}' => $GOD->headerHTML(),
			'{{define}}' => $define
		);

		echo $GOD->_visao($GOD->_layout('maydana', 'maydana'), $mustache);
	}
}