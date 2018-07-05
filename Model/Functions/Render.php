<?
/*
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Render HTML",
	"LAST EDIT": "05/07/2018",
	"VERSION":"0.0.6"
*/

class Model_Functions_Render{

	public $_util;

	function __construct(){

		$this->_util = new Model_Pluggs_Utilit;
	}

	function __destruct(){

		$this->_util = null;
	}

	function getconfig($configuracoes){

		
		$var = '';
		foreach ($configuracoes as $value){

			$nome = '-';
			if(isset($value['nome']) and !empty($value['nome'])){
				$nome = $this->_util->basico($value['nome']);
			}

			$licenca = '-';
			if(isset($value['licenca']) and !empty($value['licenca'])){
				$licenca = $this->_util->basico($value['licenca']);
			}
			
			$modulo = '-';
			if(isset($value['modulo']) and !empty($value['modulo'])){
				$modulo = $this->_util->basico($value['modulo']);
			}
			

			$validade = '-';
			if(isset($value['validade']) and !empty($value['validade'])){
				$validade =$this->_util->basico( $value['validade']);
			}

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

	function getClientes($dados){

		$total = count($dados);
		$li = '';
		foreach ($dados as $arr){
			
			$nome = $arr['nome'] ?? '';
			$cpf = $arr['cpf'] ?? '';

			$li .= <<<li
			<li class="list-group-item">
				<img class="img-circle media-object pull-left" src="{{static}}img/avatar2.png" width="32" height="32">
				<div class="media-body">
					<strong>{$nome}</strong>
					<p>{$cpf}</p>
				</div>
			</li>
li;
		}

		$var = <<<var
		<li class="list-group-item">
			<div class="media-body">
				<p>encontramos {$total} clientes</p>
			</div>
		</li>
		{$li}
var;
		return $var;
	}
}