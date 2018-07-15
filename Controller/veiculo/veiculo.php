<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "15/07/2018",
		"CONTROLADOR": "Veiculo",
		"LAST EDIT": "15/07/2018",
		"VERSION":"0.0.1"
	}
*/
class Veiculo {

	public $_func;

	public $_conexao;

	public $_consulta;

	public $_render;

	public $_cor;

	private $_push = false;

	public $foo;

	function __construct(){

		$this->_func = new Model_Functions_Functions;

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);

		$this->_render = new Model_Functions_Render;

		$this->_cor = new Model_GOD;

		$this->foo = new Model_Functions_Exception($this->_conexao);

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}

		/* checkLogin é para páginas que precisam de login */
		$this->_func->checkLogin();

		
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

		if(isset($_POST['nome'], $_POST['sexo'], $_POST['cidade'], $_POST['descricao']) and !empty($_POST['nome'])){

			$nome 		= $_POST['nome'] ?? null;
			$sexo 		= $_POST['sexo'] ?? 0;
			$cidade 	= $_POST['cidade'] ?? 0;
			$descricao 	= $_POST['descricao'] ?? null;

			$dados[] = $nome;
			$dados[] = $sexo;
			$dados[] = $cidade;
			$dados[] = $descricao;

			$newPessoa = $this->foo->newPessoa($dados);

			switch ($newPessoa) {

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