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

	function HASH_RANDOM(){
		return uniqid(rand(), true);
	}

	function HASH_URL($string){

		/**
		** @see NUNCA !!!!
		** @see NUNCA, JAMAIS, ALTERE O VALOR DA VARIÁVEL $salt
		**/
		$string = (string) $string;
		$salt = '1q23w32dcf87g7OPIH)WS+-*)(&@!$*("!$-=IHDwqpqwfdpnb';

		return sha1(substr(md5($salt.$string), 5,12));
	}

	function noLogin(){
		if(isset($_SESSION[CLIENTE]['login'])){
			header('location: /');
		}
	}

	function basico($string){

		$string = (string) $string;

		return addslashes(strip_tags(trim($string)));
	}

	function initSession($array){

		/** CRIA A SESSION LOGIN **/
		foreach ($array as $key => $value){
			$_SESSION[CLIENTE]['login'][$key] = $value;
		}
	}

	function endSession($array){

		/** 'DESTROI' A SESSION LOGIN **/
		foreach ($array as $key => $value){
			unset($_SESSION[CLIENTE]['login'][$key]);
		}
	}
}