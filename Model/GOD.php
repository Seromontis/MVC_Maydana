<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "09/04/2018",
	"MODEL": "GOD",
	"LAST EDIT": "29/04/2018",
	"VERSION":"0.0.2"
}
*/
class Model_God extends Model_Functions_Functions{


	function __construct(){
	}

	function gerarSQL($dados){

		$sql = '';
		if(is_array($dados) and !empty($dados) and count($dados) > 0 and isset($dados['tabela']) and !empty($dados['tabela'])){

			if($dados['acao'] == 'update'){

				$sql = '';
				$tabela = $dados['tabela'];
				$valor  = $dados['valor'];
				$valor = '';

				$forBind = array();
				foreach($dados['valor'] as $key => $value){
					$key = $this->basico($key);
					$value = $this->basico($value);
					$valor .= $key.' = :'.$key.'New'.', ';
					$forBind[$key] = $value;
				}

				$where = '';
				foreach($dados['where'] as $key => $value){
					$key = $this->basico($key);
					$value = $this->basico($value);
					$where .= $key.' = :'.$key.' AND ';
					$forBind[$key] = $value;
				}

				$valor = trim($valor, ', ');
				$where = trim($where, ' AND ');

				$sql = 'UPDATE '.$tabela.' SET '.$valor.' WHERE '.$where;

				return $sql;

			}elseif($dados['acao'] == 'insert'){

				$sql = '';
				$tabela = $dados['tabela'];
				$keys = '';
				$values = '';

				$forBind = array();
				foreach($dados['valor'] as $key => $value){
					$key = $this->basico($key);
					$keys .= $key.', ';
					$values .= ':'.$key.', ';
					$forBind[$key] = $value;
				}

				$keys = trim($keys, ', ');
				$values = trim($values, ', ');

				$sql = 'INSERT INTO '.$tabela.'('.$keys.') VALUES ('.$values.')';

				return $sql;

			}elseif($dados['acao'] == 'delete'){

				$sql = '';
				$tabela = $dados['tabela'];
				$values = '';
				foreach($dados['valor'] as $key => $value){
					$key = $this->basico($key);
					$values .= $key.' = :'.$key.' AND ';
				}

				$values = trim($values, ' AND ');

				$sql = 'DELETE FROM '.$tabela.' WHERE '.$values;
				return $sql;

			}elseif($dados['acao'] == 'select'){

				$sql = '';
				$tabela = $dados['tabela'];
				$select = '';
				$where = '';
				foreach($dados['select'] as $key => $value){
					$value = $this->basico($value);
					$select .= $value.', ';
				}

				foreach($dados['param'] as $key => $value){
					$value = $this->basico($key);
					$where .= $key.' = :'.$key.' AND ';
				}

				$select = trim($select, ', ');
				$where = trim($where, ' AND ');

				$sql = 'SELECT '.$select.' FROM '.$tabela.' WHERE '.$where;
				return $sql;
			}
		}

	}
}