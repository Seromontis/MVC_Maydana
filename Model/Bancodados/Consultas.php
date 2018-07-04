<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "07/06/2018",
	"MODEL": "Consultas",
	"LAST EDIT": "04/07/2018",
	"VERSION":"0.0.3"
}
*/
class Model_Bancodados_Consultas {

	public $_conexao;

	public $_util;

	public $_hoje = HOJE;

	public $_agora = AGORA;

	public $_ip = IP;

	function __construct($conexao){

		$this->_conexao = $conexao->conexao();

		$this->_util = new Model_Pluggs_Utilit;
	}

	function __destruct(){

		$this->_conexao = null;

		$this->_util = null;

	}

	function getClientes(){

		$sql = $this->_conexao->prepare('
			SELECT *
			FROM pessoas
			WHERE tipo = 1
		');
		$sql->execute();
		$fecth = $sql->fetchAll(PDO::FETCH_ASSOC);
		$sql = null;

		return $fecth;
	}

	function newPessoa(array $dados){

		$nome 		= $this->_util->basico($dados[0] ?? null);
		$sexo 		= $this->_util->basico($dados[1] ?? 0);
		$cidade 	= $this->_util->basico($dados[2] ?? 0);
		$descricao 	= $this->_util->basico($dados[3] ?? null);

		$sql = $this->_conexao->prepare("INSERT INTO pessoas (
			nome, 
			sexo, 
			cid_codigo, 
			descricao
		) VALUES (
			:nome,
			:sexo,
			:cidade,
			:descricao
		)");
		$sql->bindParam(':nome', $nome);
		$sql->bindParam(':sexo', $sexo);
		$sql->bindParam(':cidade', $cidade);
		$sql->bindParam(':descricao', $descricao);
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

		$sql = null;
		$PDO = null;

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
			$temp = $sql->fetch(PDO::FETCH_ASSOC);

			$sql = null;
			$PDO = null;

			return $temp;
		}

		return false;
	}
}