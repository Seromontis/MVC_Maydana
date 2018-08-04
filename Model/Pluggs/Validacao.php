<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "31/07/2018",
	"MODEL": "Validacão",
	"LAST EDIT": "31/07/2018",
	"VERSION":"0.0.1"
}
*/

class Model_Pluggs_Validacao {
	
	function __construct(){

	}

	function _criarLogin(array $dados){

		$error 		= 0;
		$mensagem 	= '';

		/* VALIDAÇÃO DE NOME */
		$nome 	= $dados['nome'];

		if(empty($nome)){

			$error = 1;
			$mensagem = 'Informe seu nome, ou você não tem!?';

		}elseif(!preg_match('/[A-Z][a-z]* [A-Z][a-z]*/', $nome)){

			$error = 1;
			$mensagem = 'Informe seu nome completo e correto!';

		}elseif(strlen($nome) < 6){

			$error = 1;
			$mensagem = 'Informe seu nome completo!';

		}elseif(strlen($nome) > 35){

			$error = 1;
			$mensagem = 'Porra! Seu nome é muito grande, diminiu isso!';
		}

		/* SE HOUVER ERRO, EXIBIR */
		if($error > 0){

			return $mensagem;
		}

		/* VALIDAÇÃO EMAIL */
		$email 		= $dados['email'];
		$matchEmail = '/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/';
		
		if(empty($email)){

			$error = 1;
			$mensagem = 'Informe seu e-mail caralho!';

		}elseif(!preg_match($matchEmail, $email)){

			$error = 1;
			$mensagem = 'Esse e-mail é inválido, está tentando enganar quem ?';

		}elseif(strlen($email) > 50){

			$error = 1;
			$mensagem = 'Seu e-mail é muito grande! arruma outro aí..';
		}

		/* SE HOUVER ERRO, EXIBIR */
		if($error > 0){

			return $mensagem;
		}


		/* VALIDAÇÃO SENHA */
		$senha 	= $dados['senha'];
		if(empty($senha)){

			$error = 1;
			$mensagem = 'Informe sua senha, como pretende ser identificado se não for por senha?';
		
		}elseif(strlen($senha) < 8){

			$error = 1;
			$mensagem = 'Sua senha precisa ter mais de 8 digitos, capricha ae!';

		}elseif(strlen($senha) > 50){

			$error = 1;
			$mensagem = 'Sua senha não pode ser muito longa, você é muito exagerado!';
		}

		/* SE HOUVER ERRO, EXIBIR */
		if($error > 0){

			return $mensagem;
		}

		if($error === 0){
			return true;
		}

	}
}