# API Funcionário CRUD

Esse exemplo apresenta uma estrutura *full stack* de CRUD para uma tabela de Funcionários bastante simples.

## Estrutura e Arquivos

- **Banco de Dados**: O SQL do banco de dados foi implementado em PostgreSQL.
  - `funcionario.sql`: SQL da criação da tabela funcionário.
- **Back-end**: implementado em linguagem de programação PHP, funcionando sob o servidor http Apache.
  - `.htaccess`: contém informações para permitir que os métodos sejam utilizados pelo servidor http Apache.
  - `index.php`: serviço web RESTFul para acesso ao back-end.
- **Front-end**: desenvolvido usando HTML, CSS e JavaScript.
  - `app.css`: um arquivo css da aplicação.
  - `app.html`: html da aplicação web.
  - `app.js`: javascript da aplicação.

## Interface para Acesso ao Back-End

Para acessar o Back-end implementei 4 métodos: GET, POST, PUT e DELETE.

### Método GET

O método GET, se utilizado sem parâmetros, retorna uma lista de objetos, sendo que cada objeto é um registro armazenado na tabela de funcionários. Não implementei filtro, então retora todos os objetos.

**Exemplo:**

Chamada:

```text
Metodo: GET
Link: http://localhost/~saulo/aula/api/funcionarios/
```

Exemplo de Retorno:

```json
[
  {
    "id": "1",
    "nome": "Frodo Bolseiro",
    "funcao": "Desenvolvedor Junior",
    "salario": "R$ 3.000,00"
  },
  {
    "id": "2",
    "nome": "Sanwise Gamgee",
    "funcao": "Game Designer",
    "salario": "R$ 9.500,00"
  }
]
```

Se for utilizado com o parâmetro ``id``, retorna apenas um registro específico na forma de um objeto JSON.

Exemplo de chamada com parâmetro:

```text
Método: GET
Link: http://localhost/~saulo/aula/api/funcionarios/?id=1
```

Exemplo de retorno da chamada com parâmetro:

```json
{
  "id": "1",
  "nome": "Frodo Bolseiro",
  "funcao": "Desenvolvedor Junior",
  "salario": "R$ 3.000,00"
}
```

> Veja que no primeiro caso retorna uma lista de objetos, e no segundo caso apenas um objeto (não uma lista).

### Método POST

O método POST é utilizado para gravar um registro no banco de dados. Enviamos um objeto JSON com as informações necessárias.

Exemplo de chamada POST:

```text
Método: POST
Link: http://localhost/~saulo/aula/api/funcionarios/
```

Parâmetro `body`:

```json
{
  "id":"2",
  "nome":"Sanwise Gamgee",
  "funcao":"Game Designer",
  "salario":"9.500,00"
}
```

Exemplo de retorno se sucesso:

```json
{ "result": "OK" }
```

### Método PUT

Efetua uma alteração de um registro na tabela funcionario doo banco de dados.

Ao enviar um objeto JSON com um `id` existente na tabela, altera os demais dados do registro.

Exemplo de chamada^

```text
Método: PUT
Link: http://localhost/~saulo/aula/api/funcionarios/
```

Parâmetro `body`:

```json
{
  "id":"2",
  "nome":"Sanwise Gamgee",
  "funcao":"Game Designer Pleno",
  "salario":"11.400,00"
}
```

Exemplo de retorno se sucesso:

```json
{ "result": "OK" }
```

### Método DELETE

Exclui um registro da tabela. O id do registro que se quer excluir é enviado no `body` na forma de um objeto JSON.

```text
Método: DELETE
Link: http://localhost/~saulo/aula/api/funcionarios/
```

Parâmetro `body`:

```json
{ "id":"1" }
```

Exemplo de retorno se sucesso:

```json
{ "result": "OK" }
```
