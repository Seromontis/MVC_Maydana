<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Conexao",
	"LAST EDIT": "09/04/2018",
	"VERSION":"0.0.1"
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
}

