<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Conexao",
	"LAST EDIT": "29/04/2018",
	"VERSION":"0.0.2"
}
*/
class Model_Query_Conexao{

	function conexao(){

		try{

			$banco = BANCO_DADOS;
			if($banco == 'pgsql'){

				// POSTGRES
				$PDO = new PDO('pgsql:host='.DB_HOST.' dbname='.DB_NAME.' user='.DB_USER.' password='.DB_PASS.' port='.DB_PORT.'');
				return $PDO;

			}else{

				// MYSQL 
				$PDO = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.'', DB_USER, DB_PASS);
				return $PDO;
			}

		}catch(PDOException $e){

			$this->controller = 'erro404';
			$this->action 	  = 'erro404';
			$this->visao 	  = 'erro404';

			try{

				require_once (DIR.'Controller/erro404/erro404.php');

			}catch(PDOException $e){

				/**
				** Caso controlador não seja encontrado
				**/
			}

			$controlador = new $this->controller;
			$controlador->index();
			exit;
		}
	}

	function SQL($dados){

		$PDO = $this->conexao();
		if($dados['acao'] == 'update'){

			$sql = $this->gerarSQL($dados);
			$sql = $PDO->prepare($sql);

			foreach ($dados['param'] as $key => &$val) {

				$sql->bindParam($key, $val);
			}
			$sql->execute();
			$temp = $sql->rowCount();
			$sql = null;

			if($temp){

				new de('Alterado com Sucesso!');

			}else{

				new de('Erro ao tentar alterar!');
			}

		}else if($dados['acao'] == 'insert'){

			$sql = $this->gerarSQL($dados);
			$sql = $PDO->prepare($sql);

			foreach ($dados['param'] as $key => &$val) {

				$sql->bindParam($key, $val);
			}
			$sql->execute();
			new de($sql->errorInfo());
			$temp = $sql->fetch(PDO::FETCH_ASSOC);
			$sql = null;

			if($temp === true){

				new de('Salvo com Sucesso!');

			}else{

				new de('Erro ao salvar!');
			}
		}else if($dados['acao'] == 'delete'){

			$sql = $this->gerarSQL($dados);
			$sql = $PDO->prepare($sql);

			foreach ($dados['param'] as $key => &$val) {

				$sql->bindParam($key, $val);
			}
			$sql->execute();
			$temp = $sql->fetch(PDO::FETCH_ASSOC);
			$sql = null;

			if($temp === true){

				new de('Deletado com Sucesso!');

			}else{

				new de('Erro ao deletar!');
			}

		}else if($dados['acao'] == 'select'){

			$sql = $this->gerarSQL($dados);
			$sql = $PDO->prepare($sql);

			foreach ($dados['param'] as $key => &$val) {

				$sql->bindParam($key, $val);
			}
			$sql->execute();
			$temp = $sql->fetchAll(PDO::FETCH_ASSOC);
			$sql = null;

			new de($temp);
		}
	}
}

