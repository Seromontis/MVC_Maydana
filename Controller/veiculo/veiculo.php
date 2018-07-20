<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "15/07/2018",
		"CONTROLADOR": "Veiculo",
		"LAST EDIT": "20/07/2018",
		"VERSION":"0.0.2"
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

	function __construct(){

		$this->_func = new Model_Functions_Functions;

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);

		$this->_render = new Model_Functions_Render;

		$this->_cor = new Model_GOD;

		$this->_utilit = new Model_Pluggs_Utilit;

		$this->foo = new Model_Functions_Exception($this->_conexao);

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}

		/* checkLogin é para páginas que precisam de login */
		$this->_func->checkLogin();

		
	}
		
	function generateView($img, $width = WIDTH_VIEW, $height = HEIGHT_VIEW, $quality = 70){

		if(is_file($img)){

			$imagick = new Imagick(realpath($img));
			$imagick->setImageFormat('jpg');
			$imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
			$imagick->setImageCompressionQuality($quality);
			$imagick->thumbnailImage($width, $height, false, false);
			$filename_no_ext = trim(explode('/origin/', $img)[1], FORMATO_THUMBS);

			if(file_put_contents(URL_IMG_VEICULOS.$filename_no_ext.FORMATO_THUMBS, $imagick) === false) {

				throw new Exception("Could not put contents.");
			}

			return true;

		}else{

			throw new Exception("No valid image provided with {$img}.");
		}
	}

	function generateThumbnail($img, $width = WIDTH_THUMB, $height = HEIGHT_THUMB, $quality = 90){

		if(is_file($img)){

			$imagick = new Imagick(realpath($img));
			$imagick->setImageFormat('jpg');
			$imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
			$imagick->setImageCompressionQuality($quality);
			$imagick->thumbnailImage($width, $height, false, false);
			$filename_no_ext = trim(explode('/origin/', $img)[1], FORMATO_THUMBS);

			if(!file_exists(URL_IMG_VEICULOS)){
				mkdir(URL_IMG_VEICULOS, 777);
				mkdir(URL_IMG_VEICULOS_THUMBS, 777);
				mkdir(URL_IMG_VEICULOS_ORIGIN, 777);
			}


			if(file_put_contents(URL_IMG_VEICULOS_THUMBS.$filename_no_ext.SUBNOME_THUMBS.FORMATO_THUMBS, $imagick) === false) {

				throw new Exception("Could not put contents.");
			}

			return true;

		}else{

			throw new Exception("No valid image provided with {$img}.");
		}
	}

	function index(){

		$configuracoes = $this->_consulta->getConfig($_SESSION[CLIENTE]['login']);

		$conf = $this->_render->getconfig($configuracoes);

		$clientesarray 	= $this->_consulta->getClientes();
		$clientes 		= $this->_render->getClientes($clientesarray);

		$mustache = array(
			'{{clientes}}' 		=> $clientes,
			'{{clientesarray}}' => json_encode($clientesarray)
		);

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('veiculo', 'veiculo'), $mustache);

		}else{

			echo $this->_cor->push('veiculo', 'veiculo', $mustache);
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
				        // tenta mover o arquivo para o destino
				if(move_uploaded_file($arquivo_tmp, $destino)){

					$destinoThumb = URL_IMG_VEICULOS_ORIGIN.$nomeImagem.FORMATO_THUMBS;

					/* GERA THUMB */
					try {

						$this->generateThumbnail($destinoThumb);

						$this->generateView($destinoThumb);
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

			$nome 		= $_POST['nome'] ?? null;
			$modelo 	= $_POST['modelo'] ?? null;
			$tipo 		= $_POST['tipo'] ?? null;
			$descricao 	= $_POST['descricao'] ?? null;
			$imagem 	= $_FILES['imagem'] ?? null;

			$dados[] = $nome;
			$dados[] = $modelo;
			$dados[] = $tipo;
			$dados[] = $descricao;
			$dados[] = $imagem;

			$newVeiculo = $this->foo->newVeiculo($dados);

			switch ($newVeiculo) {

				case 85:

					echo json_encode(array('res' => 'no', 'info' => 'Ocorreu um erro, entre em contato com o suporte!'));
					break;
				
				case 2:

					echo json_encode(array('res' => 'no', 'info' => 'Não foi possível registrar um novo cliente!'));
					break;

				default:

					echo json_encode(array('res' => 'ok', 'info' => 'Novo cliente registrado com sucesso!'));
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