<?
/*
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Render HTML",
	"LAST EDIT": "28/07/2018",
	"VERSION":"0.0.8"
*/

class Model_Functions_Render{

	public $_util;

	public $menuOpcoes = <<<html
<span style="float: right;">
	<button class="btn btn-secondary" data-push="push" onclick="xhr('/{{controlador}}/remover?id={{id}}')">Remover</button>
	<button class="btn btn-primary" data-push="push" onclick="xhr('/{{controlador}}/editar?id={{id}}')">Editar</button>
<span>
html;

	function __construct(){

		$this->_util = new Model_Pluggs_Utilit;
	}

	function __destruct(){

		$this->_util = null;
	}

	function getconfig($configuracoes){

		
		$var = '';
		foreach ($configuracoes as $value){

			$nome 		= $this->_util->basico($value['nome'] ?? '-');
			$licenca 	= $this->_util->basico($value['licenca'] ?? '-');
			$modulo 	= $this->_util->basico($value['modulo'] ?? '-');
			$validade 	= $this->_util->basico($value['validade'] ?? '-');

			$var .= <<<conf
			<tr>
				<td class="text-center">{$nome}</td>
				<td class="text-center">{$licenca}</td>
				<td class="text-center">{$modulo}</td>
				<td class="text-center">{$validade}</td>
			</tr>
conf;
		}

		return $var;
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