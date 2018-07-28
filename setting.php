<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"CONFIG": "Setting",
	"LAST EDIT": "28/07/2018",
	"VERSION":"0.1.0"
}
*/

/* DEBUG DESENVOLVIMENTO */
/**
TRUE = DESENVOLVIMENTO
FALSE = PRODUCAO (saveLogs);
**/
define('DEV', true);

/**
** CONFIGURAÇÕES DO MVC
**/
define('DIR', '../');

define('SAVE_SESSIONS', 'Sessions');

// É NECESSÁRIO QUE A SESSÃO/COOKIE SEJA A MESMA DO SITE
session_save_path('../Sessions');
session_set_cookie_params(9999999, '/', $_SERVER['SERVER_NAME']);

session_start();

/* USANDO HOST-VIRTUAL url é só /, no windows é ../mvc_maydana/ */
define('URL_STATIC', '/');

// Usado somente no windows - xampp /* USADO PELO CONTROLE DE MVCs que eu criei em casa */
define('DIRETORIO_PROJETO', '../MVC_Maydana/');		// diretório

/**
** CONFIGURAÇÕES
**/

/**
** BANCO DADOS
** @param pgsql ou mysql
** @see demais dados em Model/Bancodados/Pssw
**/

define('BANCO_DADOS', 'pgsql');

define('ACTION', 'maydana_system');

/* TRUE ONLINE - FALSE DESENVOLVIMENTO */
define('PRODUCAO', false);

/* NOME CLIENTE */
define('CLIENTE', 'Prosdocimo');

define('URL_SITE', 'http://sistema.local/');

define('HOJE', date('d/m/Y'));

define('AGORA', date('H:i:s'));

define('IP', $_SERVER['REMOTE_ADDR']);

define('LAYOUT', 'layout');						// nome do layout (.html)

define('VERSION_MVC', '0.0.1'); 				// Version MVC

define('NOME_SISTEMA', '<span class="icon icon-evernote"></span> Maydana System');			// Nome Projeto

define('NOME_PROJETO', 'mvc_maydana');			// Nome Projeto

define('EXTENSAO_VISAO', '.html'); 				// Extenção das views

define('EXTENSAO_CONTROLADOR', '.php'); 		// Extenção das controllers


/**
** FUNÇÕES E MODELS
**/

define('HASH_PASSWORD', '123');


/**
** CONFIGURAÇÕES IMAGEMS
**/

$id_cliente = $_SESSION[CLIENTE]['login'] ?? 99;
define('URL_DADOS', '../Dados/');
define('URL_DADOS_CLIENTE', URL_DADOS.$id_cliente.'/');
define('URL_IMG_VEICULOS', URL_DADOS.$id_cliente.'/veiculos/');
define('URL_IMG_VEICULOS_THUMBS', URL_IMG_VEICULOS.'thumbs/');
define('URL_IMG_VEICULOS_ORIGIN', URL_IMG_VEICULOS.'origin/');
define('HEIGHT_THUMB', 190);
define('WIDTH_THUMB', 240);
define('HEIGHT_VIEW', 520);
define('WIDTH_VIEW', 840);
define('FORMATO_THUMBS', '.jpg');
define('SUBNOME_THUMBS', '_thumb');

if(!is_dir(URL_DADOS_CLIENTE)){
	mkdir(URL_DADOS_CLIENTE);

	mkdir(URL_DADOS_CLIENTE.'veiculos');
	mkdir(URL_DADOS_CLIENTE.'/veiculos/thumbs');
	mkdir(URL_DADOS_CLIENTE.'veiculos/origin');
}