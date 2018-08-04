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

class Model_Pluggs_Url {

	public function url(){

		// COLOCAR A URL EM UM ARRAY PARA TER CONTROLE MVC
		if(isset($_SERVER['REQUEST_URI']) and !empty($_SERVER['REQUEST_URI'])){

			$url = $this->explodeUrl($_SERVER['REQUEST_URI']);

			return $this->url = $url;
		}
	}

	public function explodeUrl($url){

		$array = explode('/', $url);
		$temp = array();

		foreach ($array as $key => $value) {

			$temp[$key] = preg_replace('/\!.*$|#.*$|\'.*$|\$.*$|&.*$|\*.*$|-.*$|\+.*$|/', '', $value);
		}
		
		return $temp;
	}
}