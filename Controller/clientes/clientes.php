<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "07/06/2018",
		"CONTROLADOR": "Configuracao",
		"LAST EDIT": "29/07/2018",
		"VERSION":"0.0.8"
	}
*/
class Clientes {

	public $_func;

	public $_conexao;

	public $_consulta;

	public $_render;

	public $_cor;

	public $_util;

	private $_push = false;

	public $foo;

	function __construct(){

		$this->_func = new Model_Functions_Functions;

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);

		$this->_render = new Model_Functions_Render;

		$this->_util = new Model_Pluggs_Utilit;

		$this->_cor = new Model_GOD;

		$this->foo = new Model_Functions_Exception($this->_conexao);

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}

		/* checkLogin é para páginas que precisam de login */
		$this->_func->checkLogin();
	}

	function index(){

		$configuracoes = $this->_consulta->getConfig(key($_SESSION[CLIENTE]['login']));

		$conf = $this->_render->getconfig($configuracoes);

		$clientesarray 	= $this->_consulta->getClientes();

		$mustache = array(
			'{{clientesarray}}' => json_encode($clientesarray)
		);

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('clientes', 'clientes'), $mustache);

		}else{

			echo $this->_cor->push('clientes', 'clientes', $mustache);
		}
	}

	function editar_cliente(){

		if(isset($_POST['id']) and is_numeric($_POST['id'])){

			$dados['nome'] 			= $this->_util->basico($_POST['nome'] ?? '');
			$dados['sexo'] 			= $this->_util->basico($_POST['sexo'] ?? 1);
			$dados['cid_codigo'] 	= $this->_util->basico($_POST['cid_codigo'] ?? null);
			$dados['est_codigo'] 	= $this->_util->basico($_POST['est_codigo'] ?? null);
			$dados['descricao'] 	= $this->_util->basico($_POST['descricao'] ?? '');
			
			$altera = $this->_consulta->updateSQL('pessoas', $dados, 'id', $_POST['id']);

			switch ($altera){
				case 2:
					echo json_encode(array('res' => 'no', 'info' => 'Ocorreu um erro, tente novamente mais tarde!'));
					exit;
					break;
				
				default:
					# code...
					echo json_encode(array('res' => 'ok', 'info' => 'Informações alteradas com sucesso!'));
					exit;
					break;
			}
			exit;
			
		}else{
			$this->_cor->Erro404($this->_push);
		}
	}

	function editar(){

		if(isset($_GET['id']) and is_numeric($_GET['id'])){

			$id = $_GET['id'] ?? null;

			/* DADOS DO CLIENTE - PARA EDITAR */
			$cliente = $this->foo->getCliente($id);

			$mustache = array(
				'{{editar_cliente}}' => json_encode($cliente)
			);

			if($this->_push === false){

				echo $this->_cor->_visao($this->_cor->_layout('clientes', 'editar-cliente'), $mustache);
				exit;
			}else{

				echo $this->_cor->push('clientes', 'editar-cliente', $mustache);
				exit;
			}

		}else{

			$this->_cor->Erro404($this->_push);
		}
	}

	function remover(){

		if(isset($_POST['id_cliente']) and is_numeric($_POST['id_cliente'])){

			$id = $_POST['id_cliente'] ?? null;
			$deleteCliente = $this->_consulta->deleteSQL('pessoas', 'id', $id);

			switch ($deleteCliente) {

				case 85:

					echo json_encode(array('res' => 'no', 'info' => 'Ocorreu um erro, entre em contato com o suporte!'));
					break;

				default:

				echo json_encode(array('res' => 'ok', 'info' => 'O cliente foi removido com sucesso!'));
				break;
			}

		}else{

			$this->_cor->Erro404($this->_push);
		}
	}

	function novocliente(){

		$configuracoes = $this->_consulta->getConfig(key($_SESSION[CLIENTE]['login']));

		$conf = $this->_render->getconfig($configuracoes);

		$mustache = array();

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('clientes', 'novo-cliente'), $mustache);

		}else{

			echo $this->_cor->push('clientes', 'novo-cliente');
		}
	}

	function novo(){

		if(isset($_POST['nome'], $_POST['sexo'], $_POST['cid_codigo'], $_POST['est_codigo'], $_POST['descricao']) and !empty($_POST['nome']) and !empty($_POST['sexo']) and !empty($_POST['est_codigo']) and !empty($_POST['cid_codigo'])){

			$nome 		= $_POST['nome'] ?? null;
			$sexo 		= $_POST['sexo'] ?? 0;
			$descricao 	= $_POST['descricao'] ?? null;
			$est_codigo	= $_POST['est_codigo'] ?? null;
			$cid_codigo	= $_POST['cid_codigo'] ?? null;
			$id_conta 	= key($_SESSION[CLIENTE]['login']);

			$dados[] = $nome;
			$dados[] = $sexo;
			$dados[] = $descricao;
			$dados[] = $est_codigo;
			$dados[] = $cid_codigo;
			$dados[] = $id_conta;

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
		
		/* echo $this->_cor->push('clientes', 'novo-cliente'); */
	}
}