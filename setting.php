<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"CONFIG": "Setting",
	"LAST EDIT": "07/06/2018",
	"VERSION":"0.0.6"
}
*/

/**
** CONFIGURAÇÕES DO MVC
**/
define('DIR', '../');

/* USANDO HOST-VIRTUAL url é só /, no windows é ../mvc_maydana/ */
define('URL_STATIC', '/');

// Usado somente no windows - xampp /* USADO PELO CONTROLE DE MVCs que eu criei em casa */
define('DIRETORIO_PROJETO', '../MVC_Maydana/');		// diretório

/**
** CONFIGURAÇÕES
**/

/* TRUE ONLINE - FALSE DESENVOLVIMENTO */
define('PRODUCAO', false);

/* NOME CLIENTE */
define('CLIENTE', 'Prosdocimo');

define('URL_SITE', 'http://mvc_maydana.local/');

define('HOJE', date('d/m/Y'));

define('AGORA', date('H:i:s'));

define('IP', $_SERVER['REMOTE_ADDR']);

define('LAYOUT', 'layout');						// nome do layout (.html)

define('VERSION_MVC', '0.0.1'); 				// Version MVC

define('NOME_SISTEMA', '<span class="icon icon-evernote"></span> Maydana System');			// Nome Projeto

define('NOME_PROJETO', 'mvc_maydana');			// Nome Projeto

define('EXTENSAO_VISAO', '.html'); 				// Extenção das views

define('EXTENSAO_CONTROLADOR', '.php'); 		// Extenção das controllers

define('SAVE_SESSIONS', 'Sessions');


/**
** FUNÇÕES E MODELS
**/

define('HASH_PASSWORD', '123');


/**
** BANCO DADOS
** @param pgsql ou mysql
** @see demais dados em Model/Bancodados/Pssw
**/

define('BANCO_DADOS', 'pgsql');

// É NECESSÁRIO QUE A SESSÃO/COOKIE SEJA A MESMA DO SITE
session_save_path(DIR.SAVE_SESSIONS);
session_set_cookie_params(9999999, '/', $_SERVER['SERVER_NAME']);

@session_start();