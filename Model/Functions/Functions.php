<?
/*
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Functions",
	"LAST EDIT": "09/04/2018",
	"VERSION":"0.0.1"
*/

class Model_Functions_Functions extends Model_Functions_Render {

	public $url;

	function __construct(){

	}

	/**
	** @see Estrutura básica do controlador
	** @param string - nome template
	** @param string - nome controlador
	** @param string - nome view
	** @param array  - bigodim
	** @return HTML
	**/
	function _layout($controlador, $visao){

		$eye = new Model_View;
		$layout = new Model_Layout;

		$layout->setView(LAYOUT);
		$eye->setView($controlador, $visao);
		
		return $this->comprimeHTML(str_replace('{{visao}}', $eye->visao(), $layout->Layout()));
	}

	function _visao($visao, $bigodim = null){

		if(is_array($bigodim) and $bigodim !== null and $bigodim !== ''){

			$var = $this->comprimeHTML(str_replace(array_keys($bigodim), array_values($bigodim), $visao));

			return $var;
		
		}else{

			return $this->comprimeHTML(str_replace('{{visao}}', $bigodim, $visao));
		}
	}


	/**
	** @see Função comprime HTML
	** @param string
	** @return string
	**/
	function comprimeHTML($html){

		$html = preg_replace(array("/<!--(.*?)-->/", "/\t+/"), '', $html);
		$html = str_replace(array("\t", " ", PHP_EOL), ' ', $html);
		$html = str_replace('> <', '><', $html);
		
		return str_replace('NAOENTER', PHP_EOL, $html);
	}

	function url(){

		// COLOCAR A URL EM UM ARRAY PARA TER CONTROLE MVC
		if(isset($_SERVER['REQUEST_URI']) and !empty($_SERVER['REQUEST_URI'])){

			$url = $this->explodeUrl($_SERVER['REQUEST_URI']);

			return $this->url = $url;
		}
	}

	function _token(){

		$token = $this->HASH(md5(sha1(uniqid(time()))));
		$url = URL_SITE;

		$dados = array();
		if(isset($_SESSION['token']) and !empty($_SESSION['token'])){
			unset($_SESSION['token']);
		}

		if(isset($_SESSION['url'])){
			unset($_SESSION['url']);
		}

		$_SESSION['token'] = $token;
		$_SESSION['url'] = $url;
		$dados['token'] = $token;
		$dados['url'] = $url;
		
		return $dados;
	}
	/**
	** @see Cria o hash da senha, usando MD5 e SHA-1 + Salt
	** @param string
	** @return string
	**/
   function HASH($string){

   		/**
   		** @see NUNCA !!!!
   		** @see NUNCA, JAMAIS, ALTERE O VALOR DA VARIÁVEL $salt
   		**/
   		$string = (string) $string;
		$salt = '31256578196*&%@#*(!$!+_%$(_+!%anpadfbahidpqwm,ksdpoqww[pqwṕqw[';

		return sha1(substr(md5($salt.$string), 5,25));
	}

	function explodeUrl($url){

		$array = explode('/', $url);
		$temp = array();

		foreach ($array as $key => $value) {

			$temp[$key] = preg_replace('/\?.*$|\!.*$|#.*$|\'.*$|\@.*$|\$.*$|&.*$|\*.*$|-.*$|\+.*$|\..*$/', '', $value);
		}
		
		return $temp;
	}
	
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
}