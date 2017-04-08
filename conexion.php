<?php

	class Conexion_DB{

		//Atributos
		private $mysql_host;
		private $mysql_user;
		private $mysql_password;
		private $mysql_database;
		private $mysqli;
		private $query;
		private $result;

		//Setters y Getters
		public function setMysql_host($mysql_host){
			$this->mysql_host = $mysql_host;
		}
		public function setMysql_user($mysql_user){
			$this->mysql_user = $mysql_user;
		}
		public function setMysql_password($mysql_password){
			$this->mysql_password = $mysql_password;
		}
		public function setMysql_database($mysql_database){
			$this->mysql_database = $mysql_database;
		}
		public function setMysqli($mysqli){
			$this->mysqli = $mysqli;
		}
		public function setQuery($query){
			$this->query = $query;
		}
		public function setResult($result){
			$this->result = $result;
		}
		public function getMysql_host(){
			return $this->mysql_host;
		}
		public function getMysql_user(){
			return $this->mysql_user;
		}
		public function getMysql_password(){
			return $this->mysql_password;
		}
		public function getMysql_database(){
			return $this->mysql_database;
		}
		public function getMysqli(){
			return $this->mysqli;
		}
		public function getQuery(){
			return $this->query;
		}
		public function getResult(){
			return $this->result;
		}

		//Metodos

		//Constructor recibe como parametos: host,nombre de base,usuario,pass
		public function __construct($mysql_host,$mysql_database, $mysql_user, $mysql_password){
			$this->mysql_host = $mysql_host;
			$this->mysql_database = $mysql_database;
			$this->mysql_user = $mysql_user;
			$this->mysql_password = $mysql_password;
		}

		//Conecta a la base de datos
		public function conectar(){
			$this->mysqli = mysqli_connect($this->mysql_host,$this->mysql_user,$this->mysql_password,$this->mysql_database);
			if(mysqli_connect_errno($this->mysqli)){
				echo "Fallo al conectar a MySQL: ". mysqli_connect_error();
			}
		}

		
		//ejecuta la query dada, se debe mejorar esta funcion para que sea
		//normalizada
		public function seleccionar($query){
			$datos = array();
			$this->query = $query;
							
			if($this->result = $this->mysqli->prepare($this->query)){
				//ejecuta la sentencia
				$this->result->execute();

				//vincula las variables de los resultados
				$this->result->bind_result($dato,$datos2,$datos3);

				//Obtener valores
				while($this->result->fetch()){
					array_push($datos, array($dato,$datos2,$datos3));
				}

				//Cerrar la sentencia
				$this->result->close();
			}
			return $datos;
		}
		//Cierra la conexion a la base de datos
		public function cerrarConexion(){
			mysqli_close($this->mysqli);
		}
	}

	/*$conexion = new conexion_DB('localhost','CEBADA_SQL','root','');
	$conexion->conectar();
	
	$query = "SELECT a.`fecha`, s1.temperatura, s2.temperatura 
							FROM dato a, 
							(SELECT `temperatura`, `fecha` FROM dato WHERE `id_sensor` = 1) s1, 
							(SELECT `temperatura`,`fecha` FROM dato WHERE `id_sensor` = 2) s2 
							WHERE s1.`fecha` = a.`fecha` AND s2.`fecha` = a.`fecha`
							GROUP BY a.`fecha`";

	$datos = $conexion->seleccionar($query);

	echo json_encode($datos);

	$conexion->cerrarConexion();*/
?>