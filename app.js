var url = "http://localhost/~saulo/aula/api/funcionarios/";

async function carregarDados() {
    let tbody = document.getElementById('tbody');
    tbody.innerHTML = "";
    try {
        const response = await fetch(url, {
            method: "GET",
            dataType: "json",
        });
        const result = await response.json();
        result.forEach(element => {
            let tr = document.createElement("tr");
            tr.innerHTML = `
                    <td>${element.id}</td>
                    <td>${element.nome}</td>
                    <td>${element.funcao}</td>
                    <td>${element.salario}</td>
                    <td>
                        <div class="btn-group">
                            <button class="button"
                                onclick="selecionar(${element.id});">
                                Selecionar
                            </button>
                            <button class="button"
                                onclick="excluir(${element.id});">
                                Excluir
                            </button>
                        </div>
                    </td>`;
            tbody.appendChild(tr);
        });
    } catch (error) {
        alert("Error: " + error);
    }
}

async function selecionar(id_selecionada) {
    let id = document.getElementById('id');
    id.disabled = true;
    let nome = document.getElementById('nome');
    let funcao = document.getElementById('funcao');
    let salario = document.getElementById('salario');
    try {
        const response = await fetch(`${url}?id=${id_selecionada}`, {
            method: "GET",
            dataType: "json"
        });
        const result = await response.json();
        id.value = result.id;
        nome.value = result.nome;
        funcao.value = result.funcao;
        salario.value = result.salario;
    } catch (error) {
        alert("Error: " + error);
    }
}

async function excluir(id_selecionada) {
    let data = { id: id_selecionada }
    try {
        const response = await fetch(url, {
            method: "DELETE",
            dataType: "json",
            body: JSON.stringify(data),
        });
        const result = await response.json();
        carregarDados();
        limpar();
    } catch (error) {
        alert("Error: " + error);
    }
}

async function gravar() {
    let id = document.getElementById('id');
    let nome = document.getElementById('nome');
    let funcao = document.getElementById('funcao');
    let salario = document.getElementById('salario');
    let data = {
        id: id.value,
        nome: nome.value,
        funcao: funcao.value,
        salario: salario.value,
    };
    let method = "POST";
    if (id.disabled) method = "PUT";
    try {
        const response = await fetch(url, {
            method: method,
            dataType: "json",
            body: JSON.stringify(data),
        });
        const result = await response.json();
        limpar();
        carregarDados();
    } catch (error) {
        alert("Error: " + error);
    }
}

function limpar() {
    let id = document.getElementById('id');
    id.value = "";
    id.disabled = false;
    document.getElementById('nome').value = "";
    document.getElementById('funcao').value = "";
    document.getElementById('salario').value = "";

}