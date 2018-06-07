<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "GOD",
	"LAST EDIT": "07/06/2018",
	"VERSION":"0.0.4"
}
*/
class Model_God extends Model_Functions_Functions{


	public $_conexao;

	function __construct($conexao = null){

		if($conexao !== null){

			$this->_conexao = $conexao;

		}else{

			$conexao = new Model_Bancodados_Conexao;
			$this->_conexao = $conexao;
		}
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
		$layout = new Model_Layout($this->_conexao);

		$layout->setView(LAYOUT);
		$eye->setView($controlador, $visao);

		$mustache = array(
			'{{visao}}' => $eye->visao()
		);		

		return $this->comprimeHTML(str_replace(array_keys($mustache), array_values($mustache), $layout->Layout()));
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
		$html = str_replace(PHP_EOL, ' ', $html);
		$html = str_replace('> <', '><', $html);
		
		return str_replace('NAOENTER', PHP_EOL, $html);
	}

}