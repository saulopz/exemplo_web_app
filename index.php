<?php

$db = "pgsql";
$dbname = "aulafront";
$username = "saulo";
$pass = "1234";

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$obj = new stdClass();
if (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
    $obj->error = "format of request is not JSON.";
    echo json_encode($obj);
    return;
}
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        get();
        break;
    case 'POST':
        post();
        break;
    case 'PUT':
        put();
        break;
    case 'DELETE':
        delete();
        break;
    default:
        $obj->error = "Method $method undefined";
}

echo json_encode($obj);

/*** IMPLEMENTAÇÃO DOS MÉTODOS *****************************************/

/** 
 * Função para retornar um objeto ou lista de objetos
 */
function get()
{
    global $obj, $_GET;
    $pdo = connect();
    if ($pdo == null) return;
    if (array_key_exists('id', $_GET)) {
        $query = "SELECT * FROM funcionario where id=:id";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue('id', $_GET['id']);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            $obj = $row;
            return;
        }
        $obj->error = "id $_GET[id] not found";
        return;
    }
    $query = "SELECT * FROM funcionario";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $obj = array();
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        array_push($obj, $row);
    }
}

/** 
 * Função para gravar um objeto no banco de dados
 */
function post()
{
    global $obj, $data;
    $pdo = connect();
    if ($pdo == null) return;
    try {
        $query =
            "INSERT INTO funcionario (id, nome, funcao, salario) 
            VALUES ('$data[id]', '$data[nome]', '$data[funcao]',
                 '$data[salario]')";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $obj->result = "OK";
        } else {
            $obj->result = "NOT POSSIBLE INSERT";
        }
    } catch (PDOException $e) {
        $obj->error = $e->getMessage();
    }
}

/** 
 * Função para alterar um objeto ou lista de objetos
 */
function put()
{
    global $obj, $data;
    $pdo = connect();
    if ($pdo == null) return;
    try {
        $query =
            "UPDATE funcionario
            SET nome=:nome, funcao=:funcao, salario=:salario
            WHERE id=:id";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue('id', $data['id']);
        $stmt->bindValue('nome', $data['nome']);
        $stmt->bindValue('funcao', $data['funcao']);
        $stmt->bindValue('salario', $data['salario']);
        $stmt->execute();
        $obj->result = "OK";
    } catch (Exception $e) {
        $obj->error = $e->getMessage();
    }
}

/** 
 * Função para excluir um objeto
 */
function delete()
{
    global $pdo, $obj, $data;
    $pdo = connect();
    if ($pdo == null) return;
    try {
        $query = "DELETE FROM funcionario WHERE id=:id";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue('id', $data['id']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $obj->result = "OK";
        } else {
            $obj->result = "NOT DELETED $data[id]}";
        }
    } catch (Exception $e) {
        $obj->error = $e->getMessage();
    }
}

/**
 * Conexão ao banco de Dados
 * Retorna a conexão, caso sucesso. Senão retorna nulo e um erro é
 * adicionado ao objeto JSON de retorno
 */
function connect()
{
    global $obj;
    $pdo = null;
    try {
        $pdo = new PDO("pgsql:host=localhost dbname=aulafront user=saulo password=1234");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $obj->error = $e->getMessage();
    }
    return $pdo;
}
