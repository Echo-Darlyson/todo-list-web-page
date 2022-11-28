function addTarefa(){
    // Criação da linha
    let novaLinha = document.createElement("div")
    novaLinha.classList.add("row", "p-2")

    // Criação das colunas
    let colunas = [document.createElement("div"), document.createElement("div"), document.createElement("div")]
    colunas[0].classList.add("col-md-8")
    colunas[1].classList.add("col-md-2")
    colunas[2].classList.add("col-md-2")

    // Criação da tarefa
    let novaTarefa = document.createElement("li")
    novaTarefa.innerText = document.getElementById("tarefa").value

    // Criação do botão de editar a tarefa
    let btnEditar = document.createElement("button")
    btnEditar.classList.add("btn", "btn-success")
    btnEditar.innerText = "Editar"
    btnEditar.style.fontSize = "20px"

    // Criação do botão de deletar a tarefa
    let btnDeletar = document.createElement("button")
    btnDeletar.classList.add("btn", "btn-danger")
    btnDeletar.innerText = "Deletar"
    btnDeletar.style.fontSize = "20px"

    // Adicionando os novos elementos HTML em seus respectivos lugares
    document.querySelector("#lista-tarefas").appendChild(novaLinha)
    novaLinha.appendChild(colunas[0])
    novaLinha.appendChild(colunas[1])
    novaLinha.appendChild(colunas[2])
    colunas[0].appendChild(novaTarefa)
    colunas[1].appendChild(btnEditar)
    colunas[2].appendChild(btnDeletar)
}