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

include_once 'Define/Define.php';

function getOnline($job) {
	$job = $job->workload();
	$conexao = Conexao();

	$sql = $conexao->prepare('SELECT * FROM conta');
	$sql->execute();
	$fetch = $sql->fetchAll(PDO::FETCH_ASSOC);
	$sql = null;

	$dados = json_encode($fetch);

	file_put_contents('Results/teste.txt', $dados);
}

function ativaras(){

	$m = date('i') + 1;
	$ativar = date('H').':'.$m;

	file_put_contents('Results/FIM.txt', 'Chegou a hora marcada ! '.$ativar.' xD');
}