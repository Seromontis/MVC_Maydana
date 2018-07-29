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

	function __construct($conexao){

		$this->_conexao = $conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);
	}


	function getCliente(int $id) {

		try {

			return $this->_consulta->getCliente($id);

		}catch (Exception $e) {

			return 85;

		}catch(Error $e){

			return 85;
		}
	}

	function newVeiculo($dados) {

		try {

			return $this->_consulta->newVeiculo($dados);

		}catch (Exception $e) {

			return 85;

		}catch(Error $e){

			return 85;
		}
	}

	function newPessoa($dados) {

		try {

			return $this->_consulta->newPessoa($dados);

		}catch (Exception $e) {

			return 85;

		}catch(Error $e){

			return 85;
		}
	}
}