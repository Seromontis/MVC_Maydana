#!/usr/bin/php -q
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
if(class_exists('GearmanWorker')){

	print 'Client Running...'.PHP_EOL;
	$client = new GearmanClient();
	// Add a server
	$client->addServer('127.0.0.1', 4730); // by default host/port will be "localhost" & 4730

	$m = date('i');
	$s = date('s') + 10;
	
	if($m <= 9){
		$m = '0'.$m;
	}
	if($s <= 9){
		$s = '0'.$s;
	}

	$ativar = date('H').':'.$m.':'.$s;
	$a = $m.':'.$s;

	$agora = date('H:i:s');

	echo 'Agora é '.$agora.' e o cliente tem executar a tarefa às '.$ativar.PHP_EOL;

	$estanahora = false;
	while(true){

		$b = date('i:s');
		echo 'Cliente aguardando a hora.. ( '.date('H:i:s').' )'.PHP_EOL;

		if($b >= $a){
			echo 'Chegou a hora, fim da escuta'.PHP_EOL;
			$estanahora = true;
			$client->doBackground('getOnline', 'getOnline');
			break;
		}

		// DELAY 0.01 SEGUNDO
		sleep(3);
	}

	echo 'Chegou a hora';

}else{

	print 'Ops, Você precisa instalar o Gearman!'.PHP_EOL;
}
