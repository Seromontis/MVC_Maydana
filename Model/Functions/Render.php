<?
/*
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Render HTML",
	"LAST EDIT": "09/04/2018",
	"VERSION":"0.0.2"
*/

class Model_Functions_Render extends Model_Query_Query {


	function headerHTML(){


		$url = $this->url();
		
		$noscript = '<noscript><meta  http-equiv="refresh"  content="1; URL=/noscript"  /></noscript>';
		if(isset($url[1]) and $url[1] == 'noscript'){

			$noscript = '';
		}

		$header = <<<php
<title>Matheus Maydana</title>
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
}