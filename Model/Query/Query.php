<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "Queryes SQL",
	"LAST EDIT": "09/04/2018",
	"VERSION":"0.0.1"
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

			$email = $this->basico($dados['email']);
			$senha = $this->basico($dados['senha']);
			$token = $this->basico($dados['token']);

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
							token
						) VALUES (
							:email,
							:senha,
							:token
						)";
				$sql = $PDO->prepare($sql);
				$sql->bindParam(':email', $email);
				$sql->bindParam(':senha', $senha);
				$sql->bindParam(':token', $token);
				$sql->execute();
				new de($sql->errorInfo());
				$temp = $sql->fetch(PDO::FETCH_ASSOC);
				$sql = null;

				if($temp){
					new de('criado com sucesso');
				}else{
					new de('falha ao criar');
				}

			}else{

				/* JÁ existe um registro com essa conta */
			}
		}else{

			/* VOCÊ ESTÁ NO LUGAR ERRADO*/
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
			FROM pessoas AS p 

			LEFT JOIN conta AS c ON p.conta_codigo = c.id
			WHERE id_conta = :id_conta');
			$sql->bindParam(':id_conta', $id_conta);
			$sql->execute();

			$temp = $sql->fetchAll(PDO::FETCH_ASSOC);

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