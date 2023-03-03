<?php

class Conexao {

	private $host = 'localhost';
	private $dbname = 'php_com_pdo';
	private $user = 'root';
	private $pass = '';

	public function conectar() {
		try {

			$conexao = new PDO(
				"mysql:host=$this->host;dbname=$this->dbname",
				"$this->user",
				"$this->pass"				
			);

            //o método conectar retorna a classe $conexao
			return $conexao;


		} catch (PDOException $e) {//recuperar erro
			echo '<p>'.$e->getMessege().'</p>';
		}
	}
}

?>