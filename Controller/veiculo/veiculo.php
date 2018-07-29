<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "15/07/2018",
		"CONTROLADOR": "Veiculo",
		"LAST EDIT": "29/07/2018",
		"VERSION":"0.0.5"
	}
*/
class Veiculo {

	public $_func;

	public $_conexao;

	public $_consulta;

	public $_render;

	public $_cor;

	public $_utilit;

	private $_push = false;

	public $foo;

	public $Imagick;

	function __construct(){

		$this->_func = new Model_Functions_Functions;

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);

		$this->_render = new Model_Functions_Render;

		$this->_cor = new Model_GOD;

		$this->_utilit = new Model_Pluggs_Utilit;

		$this->foo = new Model_Functions_Exception($this->_conexao);

		$this->Imagick = new Model_Pluggs_Imagick;

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}

		/* checkLogin é para páginas que precisam de login */
		$this->_func->checkLogin();
	}

	function index(){

		$configuracoes = $this->_consulta->getConfig($_SESSION[CLIENTE]['login']);

		$conf = $this->_render->getconfig($configuracoes);

		$veiculosarray 	= $this->_consulta->getVeiculos();

		$mustache = array(
			'{{veiculosarray}}' => json_encode($veiculosarray)
		);

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('veiculo', 'veiculo'), $mustache);
			exit;

		}else{

			echo $this->_cor->push('veiculo', 'veiculo', $mustache);
			exit;
		}
	}

	function imagem(){

		$configuracoes = $this->_consulta->getConfig($_SESSION[CLIENTE]['login']);

		$conf = $this->_render->getconfig($configuracoes);

		$mustache = array();

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('veiculo', 'imagem'), $mustache);
			exit;

		}else{

			echo $this->_cor->push('veiculo', 'imagem', $mustache);
			exit;
		}
	}

	function editar(){

		if(isset($_GET['id']) and is_numeric($_GET['id'])){

			$id = $_GET['id'] ?? null;

			$mustache = array();

			if($this->_push === false){

				echo $this->_cor->_visao($this->_cor->_layout('veiculo', 'editar-veiculo'), $mustache);

			}else{

				echo $this->_cor->push('veiculo', 'editar-veiculo');
			}

		}else{

			$this->_cor->Erro404($this->_push);
		}
	}

	function remover(){

		if(isset($_GET['id']) and is_numeric($_GET['id'])){

			$id = $_GET['id'] ?? null;
			$deleteCliente = $this->_consulta->deleteSQL('veiculo', 'id_veiculo', $id);

			switch ($deleteCliente) {

				case 85:

					echo json_encode(array('res' => 'no', 'info' => 'Ocorreu um erro, entre em contato com o suporte!'));
					break;

				default:

					echo json_encode(array('res' => 'ok', 'info' => 'O veiculo foi removido com sucesso!'));
					break;
			}

		}else{

			$this->_cor->Erro404($this->_push);
		}
	}

	function novoveiculo(){

		$configuracoes = $this->_consulta->getConfig($_SESSION[CLIENTE]['login']);

		$conf = $this->_render->getconfig($configuracoes);

		$mustache = array();

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('veiculo', 'novo-veiculo'), $mustache);

		}else{

			echo $this->_cor->push('veiculo', 'novo-veiculo');
		}
	}

	function novo(){

		if(isset($_FILES['imgveiculo']) and !empty($_FILES['imgveiculo'])){

			$extensaoPermitida = array('image/png', 'image/jpeg', 'image/jpg');

			if($_FILES["imgveiculo"]["type"] == $extensaoPermitida[0] OR $_FILES["imgveiculo"]["type"] == $extensaoPermitida[1] OR $_FILES["imgveiculo"]["type"] == $extensaoPermitida[2]){

				$arquivo_tmp = $_FILES["imgveiculo"]["tmp_name"];
				$nomeImagem = $this->_utilit->HASH_URL($_FILES['imgveiculo']['name']);

				$destino = URL_IMG_VEICULOS_ORIGIN.$nomeImagem.FORMATO_THUMBS;

				if(move_uploaded_file($arquivo_tmp, $destino)){

					$destinoThumb = URL_IMG_VEICULOS_ORIGIN.$nomeImagem.FORMATO_THUMBS;

					/* GERA THUMB */
					try {

						$this->Imagick->generateThumbnail($destinoThumb);

						$this->Imagick->generateView($destinoThumb);
						echo json_encode(array('res' => 'ok', 'info' => 'Thumbs salvo com sucesso!'));
						exit;

					}catch(ImagickException $e){

						echo json_encode(array('res' => 'no', 'info' => $e->getMessage()));
						exit;
					}catch (Exception $e){

						echo json_encode(array('res' => 'no', 'info' => $e->getMessage()));
						exit;
					}
				}else{

					echo json_encode(array('res' => 'no', 'info' => 'Eita, parece que você não ter missão de escrita!'));
					exit;
				}

			}else{

				echo json_encode(array('res' => 'no', 'info' => 'O Arquivo informado não é uma imagem!'));
				exit;
			}
		}

		if(isset($_POST['nome']) and !empty($_POST['nome'])){

			$publicar		= $_POST['publicar'] ?? 1;
			$tipo			= $_POST['tipo'] ?? 2;
			$ano			= $_POST['ano'] ?? 0;
			$nome 			= $_POST['nome'] ?? '';
			$modelo 		= $_POST['modelo'] ?? 0;
			$cor 			= $_POST['cor'] ?? 0;
			$marca 			= $_POST['marca'] ?? 0;
			$portas			= $_POST['portas'] ?? 1;
			$descricao 		= $_POST['descricao'] ?? '-';
			$quilometragem 	= $_POST['quilometragem'] ?? 0;
			$id_conta	 	= $_SESSION[CLIENTE]['login'];

			$dados[] = $publicar;
			$dados[] = $tipo;
			$dados[] = $ano;
			$dados[] = $nome;
			$dados[] = $modelo;
			$dados[] = $cor;
			$dados[] = $marca;
			$dados[] = $portas;
			$dados[] = $descricao;
			$dados[] = $quilometragem;
			$dados[] = $id_conta;

			$newVeiculo = $this->foo->newVeiculo($dados);

			switch ($newVeiculo) {

				case 85:

					echo json_encode(array('res' => 'no', 'info' => 'Ocorreu um erro, entre em contato com o suporte!'));
					break;
				
				case 2:

					echo json_encode(array('res' => 'no', 'info' => 'Não foi possível registrar um novo veiculo!'));
					break;

				default:

					echo json_encode(array('res' => 'ok', 'info' => 'Novo veiculo registrado com sucesso!'));
					break;
			}

			exit;
		}

		echo json_encode(array('res' => 'no', 'info' => 'Informe os dados correto'));
		exit;
		/*header('HTTP/1.0 404 Not Found', true, 404);
		header('location: /erro404');
		exit;*/
	}
}