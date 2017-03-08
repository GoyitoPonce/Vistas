<?php
class Connection {

private $hostname;
private $user;
private $password;
private $db;

public $conexion;
public $error;

public function __construct($hostname,$user,$password,$db)
	{
		$this->hostname = $hostname;
		$this->user = $user;
		$this->password = $password;
		$this->db = $db;


		if(!$this->_connect())
		{
			$this->error = @mysqli_error();
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////////////
	private function _connect()
	{
$this->conexion =  @mysqli_connect($this->hostname,$this->user,$this->password);
		if($this->conexion)
		{
@mysqli_select_db($this->conexion,$this->db);
     
		}
		else
		{
			$this->error = @mysqli_error();
			return false;
		}
	}

////////////////////////////////////////
	public function filtrar($valor)
{
   $valor = stripcslashes($valor);
   $valor = ltrim($valor);
   $valor = rtrim($valor);
   return @mysqli_real_escape_string($valor);
}

////////////////////////////////////////////////////////////////////////////////////////////////////
public function enviarQuery($query)
{
	$tipo = strtoupper(substr($query,0,6));
	switch ($tipo) {

		case 'SELECT':

			$resultado = mysqli_query($this->conexion,$query);
	
			if(!$resultado)
			{
				$this->error = @mysqli_error();
			}
			else
			{
				if(mysqli_num_rows($resultado)==0)
				{
					return false;
				}
				else{
					while($f = (mysqli_fetch_assoc($resultado)))
					{
						$r[]=$f;
					}
					mysqli_free_result($resultado);
					return $r;

				}
			}
			break;
		
		case 'INSERT':
			$resultado = mysqli_query($this->conexion,$query);
			if(!$resultado)
			{
				$this->error = @mysqli_error();
			}
			else
			{
				return mysqli_insert_id();
			}
			break;

			case 'DELETE':
			case 'TRUNCA':
			case 'UPDATE':
			$resultado = mysqli_query($this->conexion,$query);
			if(!$resultado)
			{
				$this->error = @mysqli_error();
			}
			else
			{
				return mysqli_affected_rows();
			}
			break;

			default:
			$this->error = "Tipo de Consulta no permitida";
	}
}
public function _destruct()
{
	@mysqli_close($this->conexion);
}

}

