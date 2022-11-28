<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">
    <link rel="icon" type="image/png" href="{{ URL::asset('images/to-do-list.png') }}">
    <title>Todo List</title>
</head>
    <body class="p-4 bg-dark" onload="getTasks()">

        <div class="modal fade" id="modal">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header border-0">
                        <h4 class="modal-title">Editar Tarefa</h4>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off">
                            <div class="form-group">
                                <input type="hidden" id="id-tarefa">
                                <input type="text" class="form-control" id="nome-tarefa">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                        <button class="btn btn-success" data-bs-dismiss="modal" onclick="editTask()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-4 mb-2">
                <div class="container text-center" id="container-entrada-tarefa">
                    <p class="h1" id="titulo-adicionar-tarefa">Adicione Uma Tarefa</p>
                    <div class="form-group" id="entrada-tarefa">
                        <textarea rows="4" class="form-control" id="tarefa"></textarea>
                    </div>
                    <button class="btn btn-primary" id="btn-adicionar" onclick="saveTask()">Criar</button>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="container" id="container-lista-tarefa">
                    <p class="h1 text-center" id="titulo-lista-tarefa">Tarefas</p>
                    <hr>
                    <div class="container-fluid text-white" id="container-tarefas">
                        <ul id="lista-tarefas"></ul>
                    </div>
                </div>
            </div>

        </div>

        <!-- JavaScript -->
        <script>
            function getTasks(){
                $.ajax(
                    {
                        type: "GET",
                        url: "/todolist",
                        success: function (data){

                            if(data.length == 0){
                                let novaLinha = document.createElement("div")
                                novaLinha.classList.add("container", "p-2", "sem-tarefas")

                                document.querySelector("#container-tarefas").appendChild(novaLinha)

                                novaLinha.innerHTML = `<h1>Sem Tarefas Ainda...</h1> <br> <img src="{{ URL::asset('images/list.png') }}" style="width: 20vh;">`
                            }
                            else{
                                for(let index = 0; index < data.length; index++){
                                    // Criação do botão de editar a tarefa
                                    let btnEditar = `<button class="btn btn-primary" onclick="openModal(\'${data[index].id}\', \'${data[index].name}\')" style="font-size: 20px">Editar</button>`

                                    // Criação do botão de deletar a tarefa
                                    let btnDeletar = `<button class="btn btn-danger" onclick="deleteTask(${data[index].id})" style="font-size: 20px">Deletar</button>`

                                    let novaLinha = document.createElement("div")
                                    novaLinha.classList.add("row", "p-2")

                                    let colunas = [document.createElement("div"), document.createElement("div"), document.createElement("div")]
                                    colunas[0].classList.add("col-lg-6", "col-3", "col-md-4", "col-sm-4")
                                    colunas[1].classList.add("col-lg-2", "col-2", "col-md-2", "col-sm-2")
                                    colunas[2].classList.add("col-lg-2", "col-2", "col-md-2", "col-sm-2")

                                    document.querySelector("#lista-tarefas").appendChild(novaLinha)
                                    novaLinha.appendChild(colunas[0])
                                    novaLinha.appendChild(colunas[1])
                                    novaLinha.appendChild(colunas[2])
                                    
                                    let novaTarefa = document.createElement("li")
                                    novaTarefa.innerText = data[index].name

                                    colunas[0].appendChild(novaTarefa)
                                    colunas[1].innerHTML = btnEditar
                                    colunas[2].innerHTML = btnDeletar
                                }
                            }
                        }
                    }
                )
            }

            function saveTask(){

                let tarefa = document.getElementById("tarefa").value
                if(tarefa.trim().length == 0){
                    alert("Por favor insira uma tarefa")
                }

                $.ajax(
                    {
                        type: "POST",
                        url: "/todolist",
                        data: {
                            name: tarefa
                        },
                        success: function (){
                            let semTarefa = document.getElementByClass("sem-tarefa")
                            if(semTarefa != null && typeof(semTarefa) != 'undefined'){
                                semTarefa.remove()
                            }
                            getTasks()
                        }
                    }
                )

                location.reload()
            }
            
            function deleteTask(id){

                $.ajax(
                    {
                        type: "DELETE",
                        url: `/todolist/${id}`,
                        success: function (){
                            getTasks()
                        }
                    }
                )

                location.reload()
            }

            function openModal(id, name){
                $("#modal").modal("show")
                document.getElementById("id-tarefa").value = id
                document.getElementById("nome-tarefa").value = name
            }

            function editTask(){
                const nomeTarefa = $("#nome-tarefa").val()
                const idTarefa = document.getElementById("id-tarefa").value

                if(nomeTarefa.trim().length == 0){
                    alert("Por favor insira uma tarefa")
                }

                $.ajax(
                    {
                        type: "PUT",
                        url: `/todolist/${idTarefa}`,
                        data: {
                            name: nomeTarefa
                        },
                        success: function (){
                            getTasks()
                        }
                    }
                )

                location.reload()
            }
        </script>

    </body>
</html>