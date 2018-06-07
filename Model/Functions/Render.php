<?
/*
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Render HTML",
	"LAST EDIT": "07/06/2018",
	"VERSION":"0.0.5"
*/

class Model_Functions_Render {

	public $_util;

	function __construct(){

		$this->_util = new Model_Pluggs_Utilit;
	}

	function __destruct(){

		$this->_util = null;
	}

	function conteudo($pg){

		/**
		** @param $pg (INT) id conta usuario logado
		** @see PREPARA os dados da pagina de contatos
		**
		**/

		if(is_array($pg) and count($pg) > 0 and $pg['id_conta'] == $_SESSION[CLIENTE]['login']){

			$var = array();
			foreach ($pg as $key => $value){

				if(!empty($value)){

					$value = $this->_util->basico($value);

					if($key == 'instagram' || $key == 'facebook'){
						
						$var['redesociais'][$key] = $value;
					}

					if($key == 'email' || $key == 'telefone' || $key == 'celular' || $key == 'whatsapp'){
						
						$var['contato'][$key] = $value;
					}

					if($key == 'titulo' || $key == 'subtitulo' || $key == 'mensagem'){
						
						$var['conteudo'][$key] = $value;
					}
				}
			}

			return $var;
		}

		return false;
	}
}