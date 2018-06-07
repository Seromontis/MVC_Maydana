<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "07/06/2018",
	"MODEL": "Utilit",
	"LAST EDIT": "07/06/2018",
	"VERSION":"0.0.1"
}
*/

class Model_Pluggs_Utilit {
	
	function _hoje(){
		return HOJE;
	}

	function _agora(){
		return AGORA;
	}

	function _ip(){
		return IP;
	}

	function basico($string){

		$string = (string) $string;

		return addslashes(strip_tags(trim($string)));
	}

	function initSession($array){

		/** CRIA A SESSION LOGIN **/
		foreach ($array as $key => $value){
			$_SESSION[CLIENTE][$key] = $value;
		}
	}

	function endSession($array){

		/** 'DESTROI' A SESSION LOGIN **/
		foreach ($array as $key => $value){
			unset($_SESSION[CLIENTE][$key]);
		}
	}
}