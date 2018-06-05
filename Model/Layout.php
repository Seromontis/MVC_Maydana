<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Layout",
	"LAST EDIT": "04/06/2018",
	"VERSION":"0.0.3"
}
*/


/**
**
** @see o Layout precisa ser formato .HTML ou confirgurar no arquivo Setting.php 
**
**/

class Model_Layout {

	function __construct($st_view = null, $v_params = null){
		if($st_view != null)
			$this->setView($st_view);
		$this->v_params = $v_params;
	}

	public function setView($st_view){

		try{

			if(file_exists(DIR.'Layout/'.$st_view.EXTENSAO_VISAO)){
				$this->st_view = $st_view;
			}


		}catch(PDOException $e){

			/**
			** ERRO, LAYOUT NÃO ENCONTRADO
			**/
			new de('layout não encontrado');
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

	public function Layout(){

		try{

			if(isset($this->st_view)){
				$layout = $this->st_view;

				$cliente = '';
				if(isset($_SESSION['login'])){

					$GOD = new Model_GOD;
					$PDO = $GOD->conexao();

					$sql = $PDO->prepare('SELECT nome FROM conta WHERE id_conta = :id_conta');
					$sql->bindParam(':id_conta', $_SESSION['login']);
					$sql->execute();
					$cliente = $sql->fetch(PDO::FETCH_ASSOC);
					$sql = null;
					$PDO = null;
				}


				$cliente = '';
				if(isset($cliente['nome']) and !empty($cliente['nome'])){

					$cliente = $cliente['nome'];
				}

				/* COLOCAR CACHE NOS ARQUIVOS STATICOS QUANDO NÃO ESTÁ EM PRODUÇÃO */
				$cache = '';
				if(PRODUCAO !== true){
					$cache = '?cache='.random_int(10000, 99999);
				}

				$mustache = array(
					'{{cliente}}' => $cliente,
					'{{static}}' => URL_STATIC,
					'{{cache}}' => $cache
				);

				$layout = str_replace(array_keys($mustache), array_values($mustache), file_get_contents(DIR.'Layout/'.$layout.EXTENSAO_VISAO));
				return $layout;
				
			}

		}catch(PDOException $e){

			new de('nada de layout');
			/**
			** ERRO, ARQUIVO LAYOUT NÃO ENCONTRADO
			**/
		} 
	}

	public function showContents(){
		echo $this->getContents();
		exit;
	}
}