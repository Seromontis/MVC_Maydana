<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Queryes SQL",
	"LAST EDIT": "30/05/2018",
	"VERSION":"0.0.4"
}
*/
class Model_Query_Query extends Model_Query_Conexao{


	public $conexao;

	function __construct(){

		$this->conexao = $this->conexao();
	}

	function __destruct(){

		$this->conexao = null;
	}

	function newAccount($dados){

		if(is_array($dados) and !empty($dados) and count($dados) > 0){

			$hoje 	= $this->_hoje();
			$agora 	= $this->_agora();
			$ip 	= $this->_ip();
			$email 	= $this->basico($dados['email']);
			$senha 	= $this->basico($dados['senha']);
			$token 	= $this->basico($dados['token']);

			$PDO = $this->conexao();

			$sql = $PDO->prepare('SELECT acesso FROM conta WHERE email = :email');
			$sql->bindParam(':email', $email);
			$sql->execute();
			$temp = $sql->fetch(PDO::FETCH_ASSOC);
			$sql = null;

			if(!$temp){

				$sql = "INSERT INTO conta (
					email,
					senha,
					token,
					ip_criacao,
					data_criacao,
					hora_criacao
				) VALUES (
					:email,
					:senha,
					:token,
					:ip,
					:hoje,
					:agora
				)";
				$sql = $PDO->prepare($sql);
				$sql->bindParam(':email', $email);
				$sql->bindParam(':senha', $senha);
				$sql->bindParam(':token', $token);
				$sql->bindParam(':ip', $ip);
				$sql->bindParam(':hoje', $hoje);
				$sql->bindParam(':agora', $agora);
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

			$hoje = $this->_hoje();
			$agora = $this->_agora();

			$email = $this->basico($dados['email']);
			$senha = $this->basico($dados['senha']);

			$PDO = $this->conexao();

			$sql = $PDO->prepare('SELECT acesso, id_conta FROM conta WHERE email = :email AND senha = :senha');
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
			unset($_SESSION['login']);
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

		$hoje 	= (string) $this->_hoje();
		$agora 	= $this->_agora();
		$ip 	= $this->_ip();
		$id_conta = $this->basico($id_conta);

		/* USUARIO SAINDO (LOGOUT) - MUDA STATUS */
		$status = 2;
		if($login !== null){

			/* USUARIO LOGANDO (LOGIN) - MUDA STATUS */
			$status = 3;
		}

		$PDO = $this->conexao();
		$sql = $PDO->prepare('
			UPDATE conta SET 
				status = :status, 
				hora_ultimo_login = :hora_ultimo_login, 
				data_ultimo_login = :data_ultimo_login, 
				ip_ultimo_login	= :ip_ultimo_login 
			WHERE id_conta = :id_conta
		');
		$sql->bindParam(':status', $status, PDO::PARAM_INT);
		$sql->bindParam(':hora_ultimo_login', $agora, PDO::PARAM_STR);
		$sql->bindParam(':data_ultimo_login', $hoje, PDO::PARAM_STR);
		$sql->bindParam(':ip_ultimo_login', $ip, PDO::PARAM_STR);
		$sql->bindParam(':id_conta', $id_conta, PDO::PARAM_INT);
		$sql->execute();

		$sql = null;
		$PDO = null;

		if(!isset($_SESSION['login']) || empty($_SESSION['login'])){

			$_SESSION['login'] = $id_conta;
		}
	}

	function getPessoa($id_conta){

		$id_conta = $this->basico($id_conta);

		if(is_string($id_conta) and !empty($id_conta) and $id_conta > 0){

			$PDO = $this->conexao();

			$sql = $PDO->prepare('SELECT 
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
}