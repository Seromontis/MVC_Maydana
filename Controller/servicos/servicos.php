<?php
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "01/06/2018",
		"CONTROLADOR": "Servicos",
		"LAST EDIT": "01/06/2018",
		"VERSION":"0.0.1"
	}
*/

class Servicos {
	
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

		$mustache = array(
			'{{header}}' => $GOD->headerHTML(),
		);

		echo $GOD->_visao($GOD->_layout('servicos', 'servicos'), $mustache);
	}
}