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

include 'Task.php';

if(class_exists('GearmanWorker')){

	print 'Worker Running...'.PHP_EOL;
	// Create a GearmanWorker object
 	$worker = new GearmanWorker();
	$worker->addServer('127.0.0.1', 4730);
	$worker->addFunction('getOnline', 'getOnline');

	while($worker->work()){

		if($worker->returnCode() != GEARMAN_SUCCESS){
			echo $worker->returnCode().PHP_EOL;
			break;
		}

		// DELAY 1 SEGUNDO
		sleep(1);
	}
}else{

	print 'Ops, Você precisa instalar o Gearman!'.PHP_EOL;
}
