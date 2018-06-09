<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "09/04/2018",
		"CONTROLADOR": "Erro 404",
		"LAST EDIT": "07/06/2018",
		"VERSION":"0.0.2"
	}
*/
class maydana {

	public $_cor;

	private $_push = false;

	function __construct(){

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
			'{{define}}' => $define
		);

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('maydana', 'maydana'), $mustache);

		}else{

			echo $this->_cor->push('maydana', 'maydana');
		}
	}
}