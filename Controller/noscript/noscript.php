<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "09/04/2018",
		"CONTROLADOR": "No Script",
		"LAST EDIT": "07/06/2018",
		"VERSION":"0.0.3"
	}
*/
class Noscript{

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

		$mustache = array();

		echo $GOD->_visao($GOD->_layout('noscript', 'noscript'), $mustache);
	}
}