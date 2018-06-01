<?php
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
		$GOD->checkLogin();
		/* PEGA OS DADOS DA PAGINA CONTATO NO BANCO DE DADOS */
		$pg = $GOD->siteContato($_SESSION['login']);
		/* RENDER _ PREPARA OS DADOS */
		$pg = $GOD->_conteudo($pg);

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
			'{{header}}' => $GOD->headerHTML(),
			'{{titulo}}' => $pg['conteudo']['titulo'],
			'{{subtitulo}}' => $pg['conteudo']['subtitulo'],
			'{{contato}}' => $contato,
			'{{redesociais}}' => $redesociais,
		);

		echo $GOD->_visao($GOD->_layout('contato', 'contato'), $mustache);
	}
}