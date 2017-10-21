<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
/*
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
*/

// @author lg
$app->get('/token', function (Request $request, Response $response, array $args){
   $sth = $this->apiKey; //FUNCIONA!!!!!!
   return $sth;
});

// retorna todos de uma tabela
$app->get('/users', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM user ORDER BY id");
    $sth->execute();
    $users = $sth->fetchAll();
    return $this->response->withJson($users);
});

// retorna um item da tabela pelo id
$app->get('/user/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM user WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $user = $sth->fetchObject();
    return $this->response->withJson($user);
});

// retorna o resultado de uma busca de usuários com o e-mail parecido com o que vc digitar
$app->get('/user/busca/[{query}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM user WHERE UPPER(email) LIKE :query ORDER BY nome");
    $query = "%".$args['query']."%";
    $sth->bindParam("query", $query);
    $sth->execute();
    $busca = $sth->fetchAll();
    return $this->response->withJson($busca);
});

// insere um novo usuário, funciona uma beleza!
// se aparecer um nome com acento no usuário o json vai pro banco de forma doida, basta encodificar para ficar ok. Checar: https://pt.stackoverflow.com/questions/65867/acentuação-no-json
$app->post('/add', function ($request, $response) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO user (nome, email, senha) VALUES (:nome, :email, :senha)";
    $sth = $this->db->prepare($sql);
    //$sth->bindParam("task", $input['task']); pode fazer o bind no execute tbm
    $hash_senha = password_hash($input['senha'], PASSWORD_DEFAULT); // senha fortemente encriptografada
    $sth->execute([
        ':nome' => $input['nome'],
        ':email' => $input['email'],
        ':senha' => $hash_senha
    ]); // usar ex.: password_verify($_POST['password'], $users[0]->password) quando for fazer login
    $input['id'] = $this->db->lastInsertId();
    $this->logger->info("Requisição POST para USUARIO executada");
    return $this->response->withJson($input);
});

// deleta um registro com o id especificado
$app->delete('/del/[{id}]', function ($request, $response, $args) use ($app) { // inserir "use ($app) para realizar subRequest
    $sth = $this->db->prepare("DELETE FROM user WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $del = $app->subRequest('GET', '/user/'.$args['id']); // é uma forma de verficar se o usuário foi deletado, mas aqui sempre vai dar deletado com sucesso, REVISAR DEPOIS
    if($del == 1){
        return "Deletado com sucesso!";
    }else{
        return "Erro ao deletar!";
    }
});

