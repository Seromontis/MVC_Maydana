<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "04/07/2018",
	"MODEL": "Exception",
	"LAST EDIT": "29/07/2018",
	"VERSION":"0.0.4"
}
*/
class Model_Functions_Exception extends Exception{

	public $_conexao;
	
	public $_consulta;

	public $_validacao;

	function __construct($conexao){

		$this->_conexao = $conexao;

		$this->_validacao = new Model_Pluggs_Validacao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);
	}

	function getVeiculo(int $dados) {

		try {

			return $this->_consulta->getVeiculo($dados);

		}catch (Exception $e) {

			return 85;

		}catch(Error $e){

			return 85;
		}
	}

	function getCliente(int $dados) {

		try {

			return $this->_consulta->getCliente($dados);

		}catch (Exception $e) {

			return 85;

		}catch(Error $e){

			return 85;
		}
	}

	function _criarLogin(array $dados) {

		try {

			return $this->_validacao->_criarLogin($dados);

		}catch (Exception $e) {

			return 85;

		}catch(Error $e){

			return 85;
		}
	}

	function newVeiculo(array $dados) {

		try {

			return $this->_consulta->newVeiculo($dados);

		}catch (Exception $e) {

			return 85;

		}catch(Error $e){

			return 85;
		}
	}

	function newPessoa(array $dados) {

		try {

			return $this->_consulta->newPessoa($dados);

		}catch (Exception $e) {

			return 85;

		}catch(Error $e){

			return 85;
		}
	}
}