<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "07/06/2018",
	"MODEL": "Consultas",
	"LAST EDIT": "29/07/2018",
	"VERSION":"0.0.8"
}
*/
class Model_Bancodados_Consultas {

	public $_conexao;

	public $_util;

	public $_hoje = HOJE;

	public $_agora = AGORA;

	public $_ip = IP;

	public $id_conta;

	function __construct($conexao){

		$this->id_conta = $_SESSION[CLIENTE]['login'];

		$this->_conexao = $conexao->conexao();

		$this->_util = new Model_Pluggs_Utilit;
	}

	function __destruct(){

		$this->_conexao = null;

		$this->_util = null;

	}

	function getEstados(){

		$sql = $this->_conexao->prepare('
			SELECT
				id,
				nome,
				sigla
			FROM estados
		');
		$sql->execute();
		$fetch = $sql->fetchAll(PDO::FETCH_ASSOC);
		$sql = null;

		return $fetch;
	}

	function getCidades(){

		$sql = $this->_conexao->prepare('
			SELECT
				id,
				nome,
				estado_id
			FROM cidades
		');
		$sql->execute();
		$fetch = $sql->fetchAll(PDO::FETCH_ASSOC);
		$sql = null;

		return $fetch;
	}

	function getCliente(int $id){

		$sql = $this->_conexao->prepare('
			SELECT
				telefone,
				whatsapp,
				nascimento,
				sexo,
				nome,
				tipo,
				id_conta,
				id AS id_cliente,
				est_codigo,
				rg,
				cpf,
				cid_codigo,
				celular,
				bai_codigo,
				descricao
			FROM pessoas
			WHERE id = :id
			ORDER BY nome ASC
		');
		$sql->bindParam(':id', $id);
		$sql->execute();

		if($sql->errorInfo()[0] !== '00000' and DEV !== true){
			
			$this->saveLogs($sql->errorInfo());
		}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

			new de($sql->errorInfo());
		}
		$fetch = $sql->fetch(PDO::FETCH_ASSOC);
		$sql = null;

		return $fetch;
	}

	function getVeiculos(){

		$sql = $this->_conexao->prepare("
			SELECT
			id_veiculo::text,
			nome::text,
			modelo::text,
			ano::text,
			cor::text,
			marca::text,
			descricao::text,
				CONCAT(quilometragem, ' Km') AS quilometragem,
				CASE tipo
					WHEN 1 THEN 'Novo'
					WHEN 2 THEN 'Usado'
					ELSE 'Semi-novo'
				END AS tipo,
				CASE portas
					WHEN 1 THEN '2 portas'
					ELSE '4 portas'
				END AS portas,
				CASE publicado
					WHEN 1 THEN 'publicado'
					ELSE 'Não publicado'
				END AS publicado
			FROM veiculo
			WHERE id_conta = :id_conta
			ORDER BY nome ASC
		");
		$sql->bindParam(':id_conta', $this->id_conta);
		$sql->execute();

		if($sql->errorInfo()[0] !== '00000' and DEV !== true){
			
			$this->saveLogs($sql->errorInfo());
		}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

			new de($sql->errorInfo());
		}
		$temp = $sql->fetchAll(PDO::FETCH_ASSOC);

	/*	$fetch = array();
		foreach ($temp as $key => $value){

			$fetch[$key]['id_veiculo'] = (string) $value['id_veiculo'];
			$fetch[$key]['nome'] = (string) $value['nome'];
			$fetch[$key]['modelo'] = (string) $value['modelo'];
			$fetch[$key]['ano'] = (string) $value['ano'];
			$fetch[$key]['cor'] = (string) $value['cor'];
			$fetch[$key]['marca'] = (string) $value['marca'];
			$fetch[$key]['descricao'] = (string) $value['descricao'];
			$fetch[$key]['quilometragem'] = (string) $value['quilometragem'];
			$fetch[$key]['tipo'] = (string) $value['tipo'];
			$fetch[$key]['portas'] = (string) $value['portas'];
			$fetch[$key]['publicado'] = (string) $value['publicado'];
		}*/
		$sql = null;

		return $temp;
	}
	function updateSQL($params, $id){

		$monta_sql = '';
		foreach ($params as $key => $value){

			$monta_sql .= $key." = :".$key.", ";
		}

		$monta_sql = trim($monta_sql, ', ');
		$sql = $this->_conexao->prepare('
			UPDATE pessoas SET '.$monta_sql.' WHERE id = :id
		');
		foreach ($params as $key => &$value){

			$sql->bindParam($key, $value);
		}
		$sql->bindParam(':id', $id);
		$sql->execute();
		if($sql->errorInfo()[0] !== '00000' and DEV !== true){
			
			$this->saveLogs($sql->errorInfo());
		}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

			new de($sql->errorInfo());
		}
		$fetch = $sql->fetch(PDO::FETCH_ASSOC);
		$sql = null;

		/* SUCESSO */
		$return = 1;

		if($fetch === false){

			/* FALHA */
			$return = 2;
		}

		return $return;
	}


	function deleteSQL($tabela, $coluna, $id){

		$sql = $this->_conexao->prepare('DELETE FROM '.$tabela.' WHERE '.$coluna.' = :id');
		$sql->bindParam(':id', $id);
		$sql->execute();
		if($sql->errorInfo()[0] !== '00000' and DEV !== true){
			
			$this->saveLogs($sql->errorInfo());
		}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

			new de($sql->errorInfo());
		}
		$fetch = $sql->fetch(PDO::FETCH_ASSOC);
		$sql = null;

		/* SUCESSO */
		$return = 1;

		if($fetch === false){

			/* FALHA */
			$return = 2;
		}

		return $return;
	}

	function getClientes(){

		/* BUSCA TODOS OS CLIENTES */
		$sql = $this->_conexao->prepare('
			SELECT
				telefone,
				whatsapp,
				nascimento,
				sexo,
				nome,
				tipo,
				id_conta,
				id,
				est_codigo,
				rg,
				cpf,
				cid_codigo,
				celular,
				bai_codigo,
				descricao
			FROM pessoas
			WHERE id_conta = :id_conta AND tipo = 1
			ORDER BY nome ASC
		');
		$sql->bindParam(':id_conta', $this->id_conta);
		$sql->execute();

		if($sql->errorInfo()[0] !== '00000' and DEV !== true){
			
			$this->saveLogs($sql->errorInfo());
		}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

			new de($sql->errorInfo());
		}
		$temp = $sql->fetchAll(PDO::FETCH_ASSOC);

		$fetch = array();
		foreach ($temp as $key => $arr){

			$fetch[$key]['telefone'] = (string) $arr['telefone'];
			$fetch[$key]['whatsapp'] = (string) $arr['whatsapp'];
			$fetch[$key]['nascimento'] = (string) $arr['nascimento'];
			$fetch[$key]['sexo'] = (string) $arr['sexo'];
			$fetch[$key]['nome'] = (string) $arr['nome'];
			$fetch[$key]['tipo'] = (string) $arr['tipo'];
			$fetch[$key]['id_conta'] = (string) $arr['id_conta'];
			$fetch[$key]['id'] = (string) $arr['id'];
			$fetch[$key]['est_codigo'] = (string) $arr['est_codigo'];
			$fetch[$key]['rg'] = (string) $arr['rg'];
			$fetch[$key]['cpf'] = (string) $arr['cpf'];
			$fetch[$key]['cid_codigo'] = (string) $arr['cid_codigo'];
			$fetch[$key]['celular'] = (string) $arr['celular'];
			$fetch[$key]['bai_codigo'] = (string) $arr['bai_codigo'];
			$fetch[$key]['descricao'] = (string) $arr['descricao'];
		}

		$sql = null;

		return $fetch;
	}

	function newVeiculo(array $dados){

		$publicar		= $this->_util->basico($dados[0]) ?? 1;
		$tipo			= $this->_util->basico($dados[1]) ?? 2;
		$ano			= $this->_util->basico($dados[2]) ?? 0;
		$nome 			= $this->_util->basico($dados[3]) ?? '';
		$modelo 		= $this->_util->basico($dados[4]) ?? 0;
		$cor 			= $this->_util->basico($dados[5]) ?? 0;
		$marca 			= $this->_util->basico($dados[6]) ?? 0;
		$portas			= $this->_util->basico($dados[7]) ?? 1;
		$descricao 		= $this->_util->basico($dados[8]) ?? '-';
		$quilometragem 	= $this->_util->basico($dados[9]) ?? 0;
		$id_conta 		= $this->_util->basico($dados[10]) ?? 0;

		$sql = $this->_conexao->prepare("INSERT INTO veiculo (
			id_conta,
			nome,
			ano,
			modelo,
			descricao,
			tipo,
			cor,
			marca,
			portas,
			quilometragem
		) VALUES (
			:id_conta,
			:nome,
			:ano,
			:modelo,
			:descricao,
			:tipo,
			:cor,
			:marca,
			:portas,
			:quilometragem
		)");
		$sql->bindParam(':id_conta', $id_conta);
		$sql->bindParam(':nome', $nome);
		$sql->bindParam(':ano', $ano);
		$sql->bindParam(':modelo', $modelo);
		$sql->bindParam(':descricao', $descricao);
		$sql->bindParam(':tipo', $tipo);
		$sql->bindParam(':cor', $cor);
		$sql->bindParam(':marca', $marca);
		$sql->bindParam(':portas', $portas);
		$sql->bindParam(':quilometragem', $quilometragem);
		$sql->execute();

		if($sql->errorInfo()[0] !== '00000' and DEV !== true){
			
			$this->saveLogs($sql->errorInfo());
		}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

			new de($sql->errorInfo());
		}
		$fetch = $sql->fetch(PDO::FETCH_ASSOC);
		$sql = null;

		/* SUCESSO */
		$return = 1;

		if($fetch === false){

			/* FALHA */
			$return = 2;
		}

		return $return;
	}

	function saveLogs(array $erro){

		$codigo_postgres 	= $erro[0] ?? 0;
		$tipo_postgres 		= $erro[1] ?? 0;
		$descricao 			= $erro[2] ?? '-';
		$arrayzao 			= implode(' - ', $erro);
		$usu_codigo 		= $_SESSION[CLIENTE]['login'] ?? 0;

		$sql = $this->_conexao->prepare("INSERT INTO erro_logs (
			descricao,
			data,
			hora,
			ip,
			usu_codigo,
			codigo_postgres,
			tipo_postgres,
			arrayzao
		) VALUES (
			:descricao,
			:data,
			:hora,
			:ip,
			:usu_codigo,
			:codigo_postgres,
			:tipo_postgres,
			:arrayzao
		)");
		$sql->bindParam(':descricao', $descricao);
		$sql->bindParam(':data', $this->_hoje);
		$sql->bindParam(':hora', $this->_agora);
		$sql->bindParam(':ip', $this->_ip);
		$sql->bindParam(':usu_codigo', $usu_codigo);
		$sql->bindParam(':codigo_postgres', $codigo_postgres);
		$sql->bindParam(':tipo_postgres', $tipo_postgres);
		$sql->bindParam(':arrayzao', $arrayzao);
		$sql->execute();
		$fetch = $sql->fetch(PDO::FETCH_ASSOC);
		$sql = null;

		/* SUCESSO */
		$return = 1;

		if($fetch === false){

			/* FALHA */
			$return = 2;
		}

		return $return;
	}

	function newPessoa(array $dados){

		$nome 		= $this->_util->basico($dados[0] ?? null);
		$sexo 		= $this->_util->basico($dados[1] ?? 0);
		$descricao 	= $this->_util->basico($dados[2] ?? null);
		$est_codigo	= $this->_util->basico($dados[3] ?? null);
		$cid_codigo	= $this->_util->basico($dados[4] ?? null);
		$id_conta	= $this->_util->basico($dados[5] ?? null);

		$sql = $this->_conexao->prepare("INSERT INTO pessoas (
			nome,
			sexo,
			descricao,
			est_codigo,
			cid_codigo,
			id_conta
		) VALUES (
			:nome,
			:sexo,
			:descricao,
			:est_codigo,
			:cid_codigo,
			:id_conta
		)");
		$sql->bindParam(':nome', $nome);
		$sql->bindParam(':sexo', $sexo);
		$sql->bindParam(':descricao', $descricao);
		$sql->bindParam(':est_codigo', $est_codigo);
		$sql->bindParam(':cid_codigo', $cid_codigo);
		$sql->bindParam(':id_conta', $id_conta);
		$sql->execute();

		if($sql->errorInfo()[0] !== '00000' and DEV !== true){
			
			$this->saveLogs($sql->errorInfo());
		}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

			new de($sql->errorInfo());
		}

		$fetch = $sql->fetch(PDO::FETCH_ASSOC);
		$sql = null;

		/* SUCESSO */
		$return = 1;

		if($fetch === false){

			/* FALHA */
			$return = 2;
		}

		return $return;
	}

	function newAccount($dados){

		if(is_array($dados) and !empty($dados) and count($dados) > 0){

			$email 	= $this->_util->basico($dados['email']);
			$nome 	= $this->_util->basico($dados['nome']);
			$senha 	= $this->_util->basico($dados['senha']);
			$token 	= $this->_util->basico($dados['token']);

			$sql = $this->_conexao->prepare('SELECT acesso FROM conta WHERE email = :email or nome = :nome');
			$sql->bindParam(':email', $email);
			$sql->bindParam(':nome', $nome);
			$sql->execute();
			$temp = $sql->fetch(PDO::FETCH_ASSOC);
			$sql = null;

			if(!$temp){

				$sql = "INSERT INTO conta (
					nome,
					email,
					senha,
					token,
					ip_criacao,
					data_criacao,
					hora_criacao
				) VALUES (
					:nome,
					:email,
					:senha,
					:token,
					:ip,
					:hoje,
					:agora
				)";
				$sql = $this->_conexao->prepare($sql);
				$sql->bindParam(':nome', $nome);
				$sql->bindParam(':email', $email);
				$sql->bindParam(':senha', $senha);
				$sql->bindParam(':token', $token);
				$sql->bindParam(':ip', $this->_ip);
				$sql->bindParam(':hoje', $this->_hoje);
				$sql->bindParam(':agora', $this->_agora);
				$sql->execute();

				if($sql->errorInfo()[0] !== '00000' and DEV !== true){
					
					$this->saveLogs($sql->errorInfo());
				}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

					new de($sql->errorInfo());
				}
				$temp = $sql->fetch(PDO::FETCH_ASSOC);
				$sql = null;

				if(!$temp){
					return 1;
				}else{

					return 2;
				}

			}else{

				/* JÁ existe um registro com essa conta */
				return 3;
			}
		}else{

			/* VOCÊ ESTÁ NO LUGAR ERRADO*/
			return 4;
		}
	}

	function login($dados){

		if(is_array($dados) and !empty($dados) and count($dados) > 0){

			$email = $this->_util->basico($dados['email']);
			$senha = $this->_util->basico($dados['senha']);

			$sql = $this->_conexao->prepare('SELECT acesso, id_conta FROM conta WHERE email = :email AND senha = :senha');
			$sql->bindParam(':email', $email);
			$sql->bindParam(':senha', $senha);
			$sql->execute();

			if($sql->errorInfo()[0] !== '00000' and DEV !== true){
				
				$this->saveLogs($sql->errorInfo());
			}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

				new de($sql->errorInfo());
			}
			$temp = $sql->fetch(PDO::FETCH_ASSOC);
			$sql = null;

			if($temp){

				$this->_timesnow($temp['id_conta'], 1);
				/* LOGADO COM SUCESSO */
				return 1;

			}else{

				/* SENHA ERRADA */
				return 3;
			}
		}else{

			/* VOCÊ ESTÁ NO LUGAR ERRADO*/
			return 4;
		}
	}

	function logout($id_conta){

		$return = 1;
		if(!empty($id_conta) and is_numeric($id_conta)){
			
			$this->_timesnow($id_conta);
			unset($_SESSION[CLIENTE]);
			$return = 2;
		}

		return $return;
	}

	function _timesnow($id_conta, $login = null){

		/**
		** @param (INT)
		** @param (boolean)
		** @see ESTA FUNÇÃO ATUALIZA OS DADOS NO BANCO, DATA, HORA E IP (last login)
		** @see SE $login vier !== null, usuario está logando
		**/

		$id_conta = $this->_util->basico($id_conta);

		/* USUARIO SAINDO (LOGOUT) - MUDA STATUS */
		$status = 2;
		if($login !== null){

			/* USUARIO LOGANDO (LOGIN) - MUDA STATUS */
			$status = 3;
		}

		$sql = $this->_conexao->prepare('
			UPDATE conta SET 
				status = :status, 
				hora_ultimo_login = :hora_ultimo_login, 
				data_ultimo_login = :data_ultimo_login, 
				ip_ultimo_login	= :ip_ultimo_login 
			WHERE id_conta = :id_conta
		');
		$sql->bindParam(':status', $status, PDO::PARAM_INT);
		$sql->bindParam(':hora_ultimo_login', $this->_agora, PDO::PARAM_STR);
		$sql->bindParam(':data_ultimo_login', $this->_hoje, PDO::PARAM_STR);
		$sql->bindParam(':ip_ultimo_login', $this->_ip, PDO::PARAM_STR);
		$sql->bindParam(':id_conta', $id_conta, PDO::PARAM_INT);
		$sql->execute();

		if($sql->errorInfo()[0] !== '00000' and DEV !== true){
			
			$this->saveLogs($sql->errorInfo());
		}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

			new de($sql->errorInfo());
		}

		$sql = null;

		if(!isset($_SESSION[CLIENTE]['login']) || empty($_SESSION[CLIENTE]['login'])){

			$_SESSION[CLIENTE]['login'] = $id_conta;
		}
	}

	function getInfoCliente($infoCliente, $id_conta){

		$sql = 'SELECT {{coluna}} FROM conta WHERE id_conta = :id_conta';
		$sql = str_replace('{{coluna}}', $infoCliente, $sql);
		$sql = $this->_conexao->prepare($sql);
		$sql->bindParam(':id_conta', $id_conta);
		$sql->execute();

		if($sql->errorInfo()[0] !== '00000' and DEV !== true){
			
			$this->saveLogs($sql->errorInfo());
		}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

			new de($sql->errorInfo());
		}
		$temp = $sql->fetch(PDO::FETCH_ASSOC);
		$sql = null;

		return $temp[$infoCliente];
	}

	function getPessoa($id_conta){

		$id_conta = $this->_util->basico($id_conta);

		if(is_string($id_conta) and !empty($id_conta) and $id_conta > 0){

			$sql = $this->_conexao->prepare('SELECT 
				p.nome,
				p.sexo,
				p.nascimento,
				p.cpf,
				c.email,
				c.senha
			FROM conta AS c
			LEFT JOIN pessoas AS p ON p.id_conta = c.id_conta
			WHERE p.id_conta = :id_conta');
			$sql->bindParam(':id_conta', $id_conta, PDO::PARAM_STR);
			$sql->execute();

			if($sql->errorInfo()[0] !== '00000' and DEV !== true){
				
				$this->saveLogs($sql->errorInfo());
			}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

				new de($sql->errorInfo());
			}

			$temp = $sql->fetch(PDO::FETCH_ASSOC);

			$sql = null;

			if($temp > 0){

				$this->_util->initSession($temp);
				return $temp;
				exit;

			}else{

				return 'Pessoa não encontrada';
				exit;
			}

			return 'Tudo ok até aqui';
			exit;

		}else{

			// Return false, não é array' 404
			return 'erro isso não é array';
			exit;
		}
	}

	function getConfig($id_conta){

		if(!empty($id_conta) and is_numeric($id_conta)){

			$sql = $this->_conexao->prepare('SELECT
				conf.nome,
				modulo.nome AS modulo,
				conf.licenca,
				conf.validade,
				conf.tipo
			FROM conta AS acc
			LEFT JOIN acc_config AS conf ON conf.id_conta = acc.id_conta
			LEFT JOIN ms_modulos AS modulo ON modulo.modulo_id = conf.modulo_id
			WHERE acc.id_conta = :id_conta');
			$sql->bindParam(':id_conta', $id_conta, PDO::PARAM_INT);
			$sql->execute();

			if($sql->errorInfo()[0] !== '00000' and DEV !== true){
				
				$this->saveLogs($sql->errorInfo());
			}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

				new de($sql->errorInfo());
			}

			$temp = $sql->fetchAll(PDO::FETCH_ASSOC);

			$sql = null;

			return $temp;
		}

		return false;

	}

	/* QUERY dados do site */
	function siteContato($id_conta){

		if(!empty($id_conta) and is_numeric($id_conta)){

			$sql = $this->_conexao->prepare('SELECT
				titulo,
				subtitulo,
				mensagem,
				email,
				telefone,
				whatsapp,
				celular,
				instagram,
				facebook,
				site,
				id_conta
			FROM site_contato
			WHERE id_conta = :id_conta');
			$sql->bindParam(':id_conta', $id_conta, PDO::PARAM_INT);
			$sql->execute();

			if($sql->errorInfo()[0] !== '00000' and DEV !== true){
				
				$this->saveLogs($sql->errorInfo());
			}elseif($sql->errorInfo()[0] !== '00000' and DEV === true){

				new de($sql->errorInfo());
			}
			$temp = $sql->fetch(PDO::FETCH_ASSOC);

			$sql = null;
			$PDO = null;

			return $temp;
		}

		return false;
	}
}