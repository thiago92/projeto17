<?php

    //o require teve que subir dois níveis porque esse arquivo ta ligado ao tarefa_controller.php que estar dentro da pasta app_lista do htdocs
	require "./tarefa.model.php";
	require "./tarefa.service.php";
	require "./conexao.php";

	//recuperando o parâmetro inserir do arquivo nova_tarefa.php da pasta principal
    //também foi feito uma condição, se o parâmetro acao for setado e ele for igual a inserir iremos dar início a lógica
    //também criarmos a variavel acao para fazer um teste se houver o indice acao setado a super global GET vamos trabalhar com $_GET['acao'] e atribuirmos a esse valor a variável acao criada caso contrário a noça aplicação vai esperar diretamente uma variável chamada acao (: $acao) -> variavel definida antes do require do arquivo no todas_tarefas.php no arquivo principal
	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

	if($acao == 'inserir' ) {
		// echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
		$tarefa = new Tarefa();
		//o set recebido é do arquivo tarefa.model.php e a super goblal POST recebe tarefa do arquivo nova_tarefa.php -> name="tarefa"
		$tarefa->__set('tarefa', $_POST['tarefa']);
		//objeto de conexão com o banco de dados do arquivo conexao.php
		$conexao = new Conexao();
		//uma instancia de TarefaService que vai fazer a conexao com o CRUD da API
		$tarefaService = new TarefaService($conexao, $tarefa);
		//executar o método inserir
		$tarefaService->inserir();
		// echo '<pre>';
        // print_r($tarefaService);
        // echo '</pre>';

        //ao inserir uma nova terafe a página deve voltar para nova_tarefa.php com um mensagem
		header('Location: nova_tarefa.php?inclusao=1');
	
	} else if($acao == 'recuperar') {
		//criar uma instancia de tarefa e um de conexão, porque tarefa.service.php na classe TarefaService espera receber uma instancia de conexão e uma de tarefa->uma necessidade do construtor
		$tarefa = new Tarefa();
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		//ne sequencia executar o metodo recuperar, que iremos atribuir a uma variável chamada de tarefas
        //que estara disponível no escopo de todas_tarefas.php
		$tarefas = $tarefaService->recuperar();
	
	} else if($acao == 'atualizar') {

		$tarefa = new Tarefa();
		//setar o id da super global post
		$tarefa->__set('id', $_POST['id'])
		//setar tarefa da super global post
			->__set('tarefa', $_POST['tarefa']);
		//instância de conexão
		$conexao = new Conexao();
		//instância de tarefaService, passando seus dois atributos, conexão e tarefa
		$tarefaService = new TarefaService($conexao, $tarefa);
		//a partir da instancia tarefaService executar o método de atualização
		if($tarefaService->atualizar()) {
			if ( isset($_GET['pag']) && $_GET['pag'] == 'index') {
				header('location: index.php');
			} else {
				header('location: todas_tarefas.php');
			}
		}


	} else if($acao == 'remover') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->remover();

		if ( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');
		} else {
			header('location: todas_tarefas.php');
		}
	
	} else if($acao == 'marcarRealizada') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->marcarRealizada();

		if ( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');
		} else {
			header('location: todas_tarefas.php');
		}
	} else if($acao == 'recuperarTarefasPendentes') {
		
		$tarefa = new Tarefa();
		$tarefa->__set('id_status', 1);
		
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		
		$tarefas = $tarefaService->recuperarTarefasPendentes();
	}

?>