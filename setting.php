<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"CONFIG": "Setting",
	"LAST EDIT": "29/05/2018",
	"VERSION":"0.0.2"
}
*/

/**
** CONFIGURAÇÕES DO MVC
**/
define('DIR', '../');

/**
** CONFIGURAÇÕES
**/

define('URL_SITE', 'http://mvc_maydana.local/');

define('HOJE', date('d/m/Y'));

define('AGORA', date('H:i:s'));

define('IP', $_SERVER['REMOTE_ADDR']);

define('LAYOUT', 'layout');						// nome do layout (.html)

define('VERSION_MVC', '0.0.1'); 				// Version MVC

define('NOME_PROJETO', 'mvc_maydana');			// Nome Projeto

define('EXTENSAO_VISAO', '.html'); 				// Extenção das views

define('EXTENSAO_CONTROLADOR', '.php'); 		// Extenção das controllers

define('SAVE_SESSIONS', 'Sessions');


/**
** FUNÇÕES E MODELS
**/

define('HASH_PASSWORD', '123');



/**
** CONEXÃO DATA_BASE
**/

define('BANCO_DADOS', 'pgsql');
define('DB_HOST', '127.0.0.1');				// Nome Host
define('DB_PORT', '5432');					// port banco dados (pgsql)
define('DB_NAME', 'maydana');				// Nome Banco
define('DB_USER', 'maydana');				// Usuário banco
define('DB_PASS', 'senhaqualquer');				// Senha Usuário

/*if(!is_dir(DIR.SAVE_SESSIONS)){
	mkdir(DIR.SAVE_SESSIONS);
}
// É NECESSÁRIO QUE A SESSÃO/COOKIE SEJA A MESMA DO SITE
session_save_path(DIR.SAVE_SESSIONS);
session_set_cookie_params(9999999, '/', $_SERVER['SERVER_NAME']);

session_start();*/