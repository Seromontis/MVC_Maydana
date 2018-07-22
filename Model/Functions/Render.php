<?
/*
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Render HTML",
	"LAST EDIT": "22/07/2018",
	"VERSION":"0.0.7"
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

	function getClientes($dados){

		$total = count($dados);
		$li = '';
		$URL_STATIC = URL_STATIC;
		foreach ($dados as $arr){
			
			$nome = $this->_util->basico($arr['nome'] ?? '');
			$cpf = $this->_util->basico($arr['cpf'] ?? '');
			$id = $this->_util->basico($arr['id'] ?? '');

			$mustache = array(
				'{{controlador}}' => 'clientes',
				'{{id}}' => $id
			);
			$opcoes = str_replace(array_keys($mustache), array_values($mustache), $this->menuOpcoes);

			$li .= <<<li
			<li class="list-group-item">
				<img class="img-circle media-object pull-left" src="{$URL_STATIC}img/avatar2.png" width="32" height="32">
				<div class="media-body">
					<strong>{$nome}</strong>
					<p>{$cpf} {$opcoes}</p>
				</div>
			</li>
li;
		}
		$resultado = '<p class="text-center">nenhum cliente encontrado</p>';
		if($total !== 0){
			$cliente = ' cliente';
			if($total > 1){
				$cliente = ' clientes';
			}

			if($total <= 9){
				$total = '0'.$total;
			}
			$resultado = '<p>encontramos '.$total.$cliente.'</p>';
		}
		$var = <<<var
		<li class="list-group-item">
			<div class="media-body">
				{$resultado}
			</div>
		</li>
		{$li}
var;
		return $var;
	}

	function getVeiculos($dados){

		$total = count($dados);
		$li = '';
		$URL_STATIC = URL_STATIC;
		foreach ($dados as $arr){
			
			$id 			= $this->_util->basico($arr['id_veiculo'] ?? '');
			$nome 			= $this->_util->basico($arr['nome'] ?? '');
			$ano 			= $this->_util->basico($arr['ano'] ?? '');
			$descricao 		= $this->_util->basico($arr['descricao'] ?? '');
			$modelo 		= $this->_util->basico($arr['modelo'] ?? '');
			$tipo 			= $this->_util->basico($arr['tipo'] ?? '');
			$cor 			= $this->_util->basico($arr['cor'] ?? '');
			$marca 			= $this->_util->basico($arr['marca'] ?? '');
			$quilometragem 	= $this->_util->basico($arr['quilometragem'] ?? '');
			$publicado 		= $this->_util->basico($arr['publicado'] ?? '');
			$portas	 		= $this->_util->basico($arr['portas'] ?? '');

			$detalhes = trim($publicado.' - '.$portas.' - '.$quilometragem.' - '.$tipo.' - '.$cor.' - '.$marca.' - '.$descricao, ' -');

			$mustache = array(
				'{{controlador}}' => 'veiculo',
				'{{id}}' => $id
			);
			$opcoes = str_replace(array_keys($mustache), array_values($mustache), $this->menuOpcoes);

			$li .= <<<li
			<li class="list-group-item">
				<img class="img-circle media-object pull-left" src="{$URL_STATIC}img/avatar2.png" width="32" height="32">
				<div class="media-body">
					<strong>{$nome} - {$ano} - {$modelo}</strong>
					<p>{$detalhes} {$opcoes}</p>
				</div>
			</li>
li;
		}

		$resultado = '<p class="text-center">nenhum veiculo encontrado</p>';
		if($total !== 0){
			$veiculo = ' veiculo';
			if($total > 1){
				$veiculo = ' veiculos';
			}

			if($total <= 9){
				$total = '0'.$total;
			}
			$resultado = '<p>encontramos '.$total.$veiculo.'</p>';
		}
		$var = <<<var
		<li class="list-group-item">
			<div class="media-body">
				{$resultado}
			</div>
		</li>
		{$li}
var;
		return $var;
	}
}