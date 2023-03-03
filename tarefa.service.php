<?php


//CRUD
class TarefaService {

	 //devemos receber os parametros e atribuir a atributos internos que representam a conexão e a tarefa
	private $conexao;
	private $tarefa;

	//tipagem de segurança (Conexao $conexao, Tarefa $tarefa), se nã for os mesmos parâmetros iremos receber uma mensagem de erro
	public function __construct(Conexao $conexao, Tarefa $tarefa) {
		//assim que eu executar conexao devo executar o método conectar do arquivo conexao.php
		$this->conexao = $conexao->conectar();
		$this->tarefa = $tarefa;
	}

	public function inserir() { //create
		$query = 'insert into tb_tarefas(tarefa)values(:tarefa)';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
		$stmt->execute();
	}

	public function recuperar() { //read
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();
		//o fetch por default recebe um array de arrays mas nesse caso vamos trabalhar como um arrays de objetos (PDO::FETCH_OBJ)
        //em seguida vamos dar o retorno desse array para a chamada do método recuperar->tarefa_controller.php
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function atualizar() { //update
		//teste para verificar se o que estamos recuperando em tarefa_controller.php, também estamos recuperando aqui
        //print_r($this->tarefa);
		$query = "update tb_tarefas set tarefa = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('tarefa'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); 
	}

	public function remover() { //delete

		$query = 'delete from tb_tarefas where id = :id';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id', $this->tarefa->__get('id'));
		$stmt->execute();
	}

	public function marcarRealizada() { //update

		$query = "update tb_tarefas set id_status = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('id_status'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); 
	}

	public function recuperarTarefasPendentes() {//read
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
			where
				t.id_status = :id_status
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
}

?>