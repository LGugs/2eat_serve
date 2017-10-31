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

// @author lg CONTINUAR!!

// Autenticação - TOKENS
$app->group('/token', function() use ($app){
  $app->post('/create', function ($request, $response, $args){
    //session_start();
    $input = $request->getParsedBody();
    define("SITE_KEY", "2eat");
    $key = md5(SITE_KEY.$input['email']);
    $_SESSION['token'] = hash('sha256', $key.$_SERVER['REMOTE_ADDR']);
    $this->logger->info("Requisição POST para criação de token bem sucedida!");
    return $_SESSION['token']; // retorna o token criado
  });

// checa se já existe um token - fazer com que ele pegue a senha do localStorage também!!
  $app->post('/check', function ($request, $response, $args){
    if(isset($_SESSION['token'])){
      $input = $request->getParsedBody();
      define("SITE_KEY", "2eat");
      $key = md5(SITE_KEY.$input['email']);
      $actual_token = hash('sha256', $key.$_SERVER['REMOTE_ADDR']);
      if($_SESSION['token'] === $actual_token){
        $this->logger->info("Requisição POST para reabrir sessão bem sucedida!");
        return 'true';
      }else{
        session_destroy();
        $this->logger->info("Requisição POST para reabrir sessão recusada - sessão anterior destruida!");
        return 'false';
      }
    }else{
      $this->logger->info("Requisição POST para reabrir sessão recusada - sessão não existe!");
      return 'false';
    }
  });

// fecha a sessão e apaga o token
  $app->get('/del', function ($request, $response, $args){
    if(isset($_SESSION['token'])){
      $this->logger->info("Requisição GET para destruir sessão bem sucedida!");
      session_destroy();
      return '0';
    }else{
      $this->logger->info("Requisição GET para destruir sessão recusada!");
      return '1';
    }
  });
});

// USUARIOS
$app->group('/user', function() use ($app){

// busca usuario por email e senha para autenticar
  $app->post('/auth', function ($request, $response) use ($app) {
    $input = $request->getParsedBody(); // podemos pegar uma variavel especifica com o $request->getParam('email'), aqui pega tudo
    $email = $input['email'];
    //$senha = $input['senha'];
    $sql = "SELECT id, nome, email, senha FROM user WHERE email = '$email'";
    $sth = $this->db->prepare($sql);
    $sth->execute();
    $user = $sth->fetchObject();
    // o password_verify verifica a senha normal com a senha "hasheada" e retornará verdadeiro caso seja a senha correta
    // checar o password verify
    if(password_verify($input['senha'], $user->senha)){
      $this->logger->info("Requisição POST para logar USUARIO bem sucedida!");
      session_start(); // starto a sessão aqui
      $_SESSION['uid'] = $user->id; // salvo o nome do caboco na session
      // este post não está enviando nada... o token/create não ta recebendo os dados
      //return $app->subRequest('POST', '/token/create', "email={$email}&senha={$user->senha}", [], [], '', new \Slim\Http\Response());
      // tentei descobrir como fazer um subrequest do token create... não deu certo. Vou fazer a aplicação chamar esta rota
      return $this->response->withJson($user); // este retorno funciona para a aplicação!
    }else{
      $this->logger->info("Requisição POST para logar USUARIO recusada!");
      return 'false';
    }
    //return $this->response->withJson($input);
  });

  //seguir um usuário
  $app->get('/follow/[{id}]', function ($request, $response, $args) {
    $sql = "INSERT INTO user_relation (id_user, id_user_follow) VALUES (:id_user, :id_user_follow)";
    $sth = $this->db->prepare($sql);
    // salva o id pela sessão e o id do seguido pelo args
    $sth->execute([
        ':id_user' => $_SESSION['uid'],
        ':id_user_follow' => $args['id']
    ]);
    $this->logger->info("Requisição GET para seguir usuário bem sucedida!");
    return 'true'; // sem retorno caso ele dê problemas!! cuidado!
  });

  //exibe lista de seguidos

  //exibe lista de seguidores


// retorna todos de uma tabela
  $app->get('/todos', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM user ORDER BY id");
    $sth->execute();
    $users = $sth->fetchAll();
    return $this->response->withJson($users);
  });

// retorna um item da tabela pelo id
  $app->get('/buscaId/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM user WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $user = $sth->fetchObject();
    return $this->response->withJson($user);
  });

// retorna o nome do caboco
  $app->get('/nome', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM user WHERE id=:id");
    $sth->bindParam("id", $_SESSION['uid']);
    $sth->execute();
    $user = $sth->fetchObject();
    return $this->response->withJson($user->nome);
    //return $user->nome;
  });

// PESQUISAR SELECT PARA SEPARAR OS USUARIOS
// retorna o resultado de uma busca de usuários com o nome parecido com o que vc digitar - tem que remover o usuário atual da pesquisa assim como os quem ele segue
  $app->get('/busca/[{query}]', function ($request, $response, $args) {
    $id = $_SESSION['uid'];
    //SELECT id FROM user WHERE id != 50 OR id != (select id_user_follow from user_relation where id_user = 50)
    $sth = $this->db->prepare("SELECT * FROM user WHERE nome LIKE :query AND id != '$id' ORDER BY nome");
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
    $this->logger->info("Requisição POST para adicionar USUARIO bem sucedida!");
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
});

$app->group('/receita', function() use ($app){

// retorna todas as receitas
  $app->get('/todos', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM receita ORDER BY tempo");
    $sth->execute();
    $receitas = $sth->fetchAll();
    return $this->response->withJson($receitas);
  });

  $app->post('/add', function ($request, $response) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO receita (titulo, ingredientes, descricao, id_user, tag) VALUES (:titulo, :ingredientes, :descricao, :id_user, :tag)";
    $sth = $this->db->prepare($sql);
    $sth->execute([
        ':titulo' => $input['titulo'],
        ':ingredientes' => $input['ingredientes'],
        ':descricao' => $input['descricao'],
        ':tag' => $input['tag'],
        ':id_user' => $_SESSION['uid']
    ]);
    $input['id'] = $this->db->lastInsertId();
    $this->logger->info("Requisição POST para adicionar RECEITA bem sucedida!");
    return $this->response->withJson($input);
  });

// retorna as receitas do usuário
  $app->get('/doChef', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM receita WHERE id_user=:id ORDER BY tempo DESC");
    $sth->bindParam("id", $_SESSION['uid']);
    $sth->execute();
    $receitas = $sth->fetchAll();
    return $this->response->withJson($receitas);
    //return $user->nome;
  });
});
