<?
/*
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Render HTML",
	"LAST EDIT": "04/06/2018",
	"VERSION":"0.0.4"
*/

class Model_Functions_Render extends Model_Query_Query {


	function headerHTML(){

		$url = $this->url();
		
		$noscript = '<noscript><meta  http-equiv="refresh"  content="1; URL=/noscript"  /></noscript>';
		if(isset($url[1]) and $url[1] == 'noscript'){

			$noscript = '';
		}

		$cliente = '';
		if(isset($_SESSION[CLIENTE]['login'])){

			$GOD = new Model_GOD;
			$PDO = $GOD->conexao();

			$sql = $PDO->prepare('SELECT nome FROM conta WHERE id_conta = :id_conta');
			$sql->bindParam(':id_conta', $_SESSION[CLIENTE]['login']);
			$sql->execute();
			$cliente = $sql->fetch(PDO::FETCH_ASSOC);
			$sql = null;
			$PDO = null;

			$cliente = '- '.$cliente['nome'];
		}

		$header = <<<php
<title>Matheus Maydana {$cliente}</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes, initial-scale=1" />
<meta name="msapplication-tap-highlight" content="no" />
<meta name="format-detection" content="telephone=no" />
<meta name="description" content="">
<meta  name="robots"  content="index, follow"  />
{$noscript}
<meta name="author" content="Matheus Maydana" />
<link rel="shortcut icon" href="/img/site/caveira.png" type="image/x-icon">
<link rel="icon" href="/img/site/caveira.png" type="image/x-icon">	
php;

		return $header;
	}

	function _conteudo($pg){

		/**
		** @param $pg (INT) id conta usuario logado
		** @see PREPARA os dados da pagina de contatos
		**
		**/

		if(is_array($pg) and count($pg) > 0 and $pg['id_conta'] == $_SESSION['login']){

			$GOD = new Model_GOD;
			$var = array();
			foreach ($pg as $key => $value){

				if(!empty($value)){

					$value = $GOD->basico($value);

					if($key == 'instagram' || $key == 'facebook'){
						
						$var['redesociais'][$key] = $value;
					}

					if($key == 'email' || $key == 'telefone' || $key == 'celular' || $key == 'whatsapp'){
						
						$var['contato'][$key] = $value;
					}

					if($key == 'titulo' || $key == 'subtitulo' || $key == 'mensagem'){
						
						$var['conteudo'][$key] = $value;
					}
				}
			}

			return $var;
		}

		return false;
	}
}