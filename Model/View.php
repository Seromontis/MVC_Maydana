<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "View",
	"LAST EDIT": "09/04/2018",
	"VERSION":"0.0.1"
}
*/

/**
**
** @see a View precisa ser formato .HTML ou confirgurar no arquivo Setting.php 
**
**/

class Model_View {

		function __construct($st_view = null, $v_params = null, $st_controlador = null){

		try{

			if($st_view !== null and $controlador !== null ){

				$this->setView($st_view);
				$this->v_params = $v_params;
				$this->st_controlador = $controlador;
			}
			
		}catch(PDOException $e){

			/**
			** ALGO DE MUITO ERRADO ACONTECEU
			**/
		}

	}

	public function setView($controlador, $st_view){

		try{

			if(file_exists(DIR.'/View/'.$controlador.'/'.$st_view.EXTENSAO_VISAO)){

				$this->st_view = $st_view;
				$this->st_controlador = $controlador;

			}else{
				
				new de('visao não encontrado');
			}

		}catch(PDOException $e){

			/**
			** ERRO, VISÃO NÃO ENCONTRADA
			**/
		}
	}

	public function getView(){
		return $this->st_view;
	}

	public function setParams(Array $v_params){
		$this->v_params = $v_params; 
	}

	public function getParams(){
		return $this->v_params;
	}

	public function visao(){

		try{

			if(isset($this->st_view)) {

				$visao = $this->st_view;
				$controlador = $this->st_controlador;

				if(file_exists(DIR.'View/'.$controlador.'/'.$visao.EXTENSAO_VISAO)){

					return file_get_contents(DIR.'View/'.$controlador.'/'.$visao.EXTENSAO_VISAO);

				}else{
					/**
					** Erro na visão
					**/
					new de('visao não encontrado');
					//echo 'erro no diretorio da visão';
				}
			}

		}catch(PDOException $e){

			new de('visao não encontrado');
			/**
			** ERRO, ARQUIVO VISÃO NÃO ENCONTRADO
			**/
		}
	}

	public function showContents(){
		echo $this->getContents();
		exit;
	}
}