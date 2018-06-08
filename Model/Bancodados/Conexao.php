<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Conexao",
	"LAST EDIT": "07/06/2018",
	"VERSION":"0.0.4"
}
*/

require_once 'Pssw.php';

class Model_Bancodados_Conexao {

	function __construct(){

	}

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

			$controller = 'erro404';
			$action 	  = 'erro404';
			$visao 	  = 'erro404';

			try{

				require_once (DIR.'Controller/erro404/erro404.php');

			}catch(PDOException $e){

				/**
				** Caso controlador não seja encontrado
				**/
			}
			//$this->controlador = new Model_error404;

		}
	}
}

