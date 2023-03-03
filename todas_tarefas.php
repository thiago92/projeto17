<?php

	$acao = 'recuperar';
	//entende que a várival que estar a acima do require vai estar disponível dentro do arquivo recuperado
	require 'tarefa_controller.php';
	// echo '<pre>';
	// print_r($tarefas);
	// echo '</pre>';

?>

<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

		<script>
			function editar(id, txt_tarefa) {
				//criar um form programático que nos permita fazer a edição
				let form = document.createElement('form')
				form.action = 'tarefa_controller.php?acao=atualizar'
				form.method = 'post'
				//deixar o campo e o botão em apenas uma linha
				form.className = 'row'

				//criar um input para entrada do texto
				let inputTarefa = document.createElement('input')
				inputTarefa.type = 'text'
				inputTarefa.name = 'tarefa'
				//deixar o campo e o botão em apenas uma linha->col-9
				inputTarefa.className = 'col-9 form-control'
				inputTarefa.value = txt_tarefa

				//criar o input hidden para guardar o id da tarefa
				let inputId = document.createElement('input')
				inputId.type = 'hidden'
				inputId.name = 'id'
				inputId.value = id

				//criar um button para enviar o form
				let button = document.createElement('button')
				button.type = 'submit'
				//deixar o campo e o botão em apenas uma linha->col-3
				button.className = 'col-3 btn btn-info'
				button.innerHTML = 'Atualizar'

				//adicionando os elementos dentro de uma hierarquia/construir a arvore de elementos para adicionar a arvore lá na página
				//incluir o inputTarefa no form
				form.appendChild(inputTarefa)

				//incluir o inputId no form

				form.appendChild(inputId)

				//incluir o button no form
				form.appendChild(button)

				//teste
				// console.log(form)

				//teste de id
				// alert(id)

				//selecionar a div tarefa
				let tarefa = document.getElementById('tarefa_'+id)

				//limpar texto da tarefa para inclusão do form
				tarefa.innerHTML = ''

				//incluir form na página atráves do insertBefore que possibilia inserir um elemento na arvore de elementos em um elemento de reinderizado
				//este elemtno espera dois parâmetros, primeiro qual será a arvore de elementos que será add, segundo qual que é o nó dentro do elemento selecionado
				//o selecionado foi o tarefa porque ele não tem nenhum elemento filho, caso tivesse teria que selecionar qual elemento filho que seria selecionado
				tarefa.insertBefore(form, tarefa[0])

				//alert(txt_tarefa)
 
			}

			function remover(id) {
				if (confirm("Tem certeza que deseja remover essa tarefa?")) {
					alert("Tarefa removida com sucesso!");
					//forçando o request para todas_tarefas.php, passando dois parametros, acao defifido como remover e id concatenando com o id recebido no remover()
					location.href = 'todas_tarefas.php?acao=remover&id='+id
				}
			}

			function marcarRealizada(id) {
				if (confirm("Tem certeza que a atividade não estar mais pendente?")) {
					alert("Tarefa alterada com sucesso!");
					location.href = 'todas_tarefas.php?acao=marcarRealizada&id='+id
				}
			}
		</script>
	</head>

	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					App Lista Tarefas
				</a>
			</div>
		</nav>

		<div class="container app">
			<div class="row">
				<div class="col-sm-3 menu">
					<ul class="list-group">
						<li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
						<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
						<li class="list-group-item active"><a href="#">Todas tarefas</a></li>
					</ul>
				</div>

				<div class="col-sm-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Todas tarefas</h4>
								<hr />

								<?php foreach($tarefas as $indice => $tarefa) {?>
									<div class="row mb-3 d-flex align-items-center tarefa">
										<div class="col-sm-9" id="tarefa_<?= $tarefa->id ?>">
											<?= $tarefa->tarefa ?> (<?= $tarefa->status ?>)
										</div>
										<!-- a seta -> é porque é um array de obj -->
										<div class="col-sm-3 mt-2 d-flex justify-content-between">
											<i class="fas fa-trash-alt fa-lg text-danger" onclick="remover(<?= $tarefa->id ?>)" style="cursor: pointer;">
											</i>
											<?php if($tarefa->status == 'pendente') { ?>
												<i class="fas fa-edit fa-lg text-info" onclick="editar(<?= $tarefa->id ?>, '<?= $tarefa->tarefa ?>')" style="cursor: pointer;">
												</i>
												<!-- o primeiro parametro é a id, já o segundo parametro é um texto, uma string, por isso deve ser capsulado dentro de '' -->
												<i class="fas fa-check-square fa-lg text-success" onclick="marcarRealizada(<?= $tarefa->id ?>)" style="cursor: pointer;"></i>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>