<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "02/05/2018",
		"CONTROLADOR": "Index",
		"LAST EDIT": "02/05/2018",
		"VERSION":"0.0.1"
	}
*/
define('BANCO_DADOS', 'pgsql');
define('DB_HOST', '127.0.0.1');				// Nome Host
define('DB_PORT', '5432');					// port banco dados (pgsql)
define('DB_NAME', 'maydana');				// Nome Banco
define('DB_USER', 'maydana');				// Usuário banco
define('DB_PASS', 'senhaqualquer');			// Senha Usuário

function Conexao(){
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
}