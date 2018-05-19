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
    $input = $request->getParsedBody();
    define("SITE_KEY", "2eat");
    $key = md5(SITE_KEY.$input['email']);
    $token = hash('sha256', $key.$_SERVER['REMOTE_ADDR']);
    $_SESSION['token'] = $token;
    $this->logger->info("Requisição POST para url: '/token/create' bem sucedida! Valor do token criado:'$token'");
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
        $this->logger->info("Requisição POST para url: '/token/check' bem sucedida! Token conferido e aceito! Sessão reaberta!");
        return 'true';
      }else{
        session_destroy();
        $this->logger->warning("Requisição POST para url: '/token/check' bem sucedida! Token não aceito, sessão foi destruída!");
        return 'false';
      }
    }else{
      $this->logger->warning("Requisição POST para url: '/token/check' bem sucedida! Sem sessão aberta!");
      return 'false';
    }
  });

// fecha a sessão e apaga o token
  $app->get('/del', function ($request, $response, $args){
    if(isset($_SESSION['token'])){
      $this->logger->info("Requisição GET para url: '/token/del' bem sucedida! Sessão destruída e token apagado!");
      session_destroy();
      return '0';
    }else{
      $this->logger->warning("Requisição GET para url: '/token/del' bem sucedida! Token não encontrado!");
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
      $this->logger->info("Requisição POST para url: '/user/auth' bem sucedida! Usuário ".$user->nome." foi logado!");
      session_start(); // starto a sessão aqui
      $_SESSION['uid'] = $user->id; // salvo o nome do caboco na session
      // este post não está enviando nada... o token/create não ta recebendo os dados
      //return $app->subRequest('POST', '/token/create', "email={$email}&senha={$user->senha}", [], [], '', new \Slim\Http\Response());
      // tentei descobrir como fazer um subrequest do token create... não deu certo. Vou fazer a aplicação chamar esta rota
      return $this->response->withJson($user); // este retorno funciona para a aplicação!
    }else{
      $this->logger->info("Requisição POST para url: '/user/auth' bem sucedida! Tentativa de logar não aceita.");
      return 'false';
    }
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
    $this->logger->info("Requisição GET para url: '/user/follow/".$args['id']."' bem sucedida! Usuário de id ".$_SESSION['uid']." agora segue usuário com o id ".$args['id']."!");
    return 'true'; // sem retorno caso ele dê problemas!! cuidado!
  });

  //exibe lista de seguidos
  $app->get('/following', function ($request, $response, $args) {
    $sql = "SELECT us.nome, us.email FROM user_relation inner join user as us on us.id = id_user_follow WHERE id_user = :id";
    $sth = $this->db->prepare($sql);
    $sth->execute([
        ':id' => $_SESSION['uid']
    ]);
    $users = $sth->fetchAll();
    $this->logger->info("Requisição GET para url: '/user/following' bem sucedida! Exibindo lista de usuários seguidos pelo usuário de id: ".$_SESSION['uid']);
    return $this->response->withJson($users); // sem retorno caso ele dê problemas!! cuidado!
  });

  //exibe lista de seguidores
  $app->get('/followers', function ($request, $response, $args) {
    $sql = "SELECT us.nome, us.email FROM user_relation inner join user as us on us.id = id_user WHERE id_user_follow = :id";
    $sth = $this->db->prepare($sql);
    $sth->execute([
        ':id' => $_SESSION['uid']
    ]);
    $users = $sth->fetchAll();
    $this->logger->info("Requisição GET para url: '/user/followers' bem sucedida! Exibindo lista de usuários que seguem o usuário de id: ".$_SESSION['uid']);
    return $this->response->withJson($users); // sem retorno caso ele dê problemas!! cuidado!
  });

// retorna todos de uma tabela
  $app->get('/todos', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM user ORDER BY id");
    $sth->execute();
    $users = $sth->fetchAll();
    $this->logger->info("Requisição GET para retornar todos os usuários bem sucedida!");
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
    $this->logger->info("Requisição GET para url: '/user/busca/".$args['query']."' bem sucedida! Exibindo lista de usuários encontrados!");
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
    $this->logger->info("Requisição POST para url: '/user/add' bem sucedida! Usuário ".$input['nome']." foi cadastrado com sucesso no sistema.");
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

  // retorna o feed do caboco, ordena por tempo
  $app->post('/feed', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $id = $_SESSION['uid'];
    if($input['ordem'] == '1'){
      $sth = $this->db->prepare("SELECT us.nome, us.foto, re.id, re.titulo, re.imagemUrl, re.nota, re.tempo, re.imagemUrl, re.tag, re.ava_num, re.comment_num FROM user_relation AS us2 INNER JOIN user AS us ON us.id = us2.id_user_follow INNER JOIN receita as re ON us2.id_user_follow = re.id_user WHERE us2.id_user = '$id' ORDER BY re.tempo DESC");
    }else{
      $sth = $this->db->prepare("SELECT us.nome, us.foto, re.id, re.titulo, re.imagemUrl, re.nota, re.tempo, re.imagemUrl, re.tag, re.ava_num, re.comment_num FROM user_relation AS us2 INNER JOIN user AS us ON us.id = us2.id_user_follow INNER JOIN receita as re ON us2.id_user_follow = re.id_user WHERE us2.id_user = '$id' ORDER BY re.nota DESC");
    }
    $sth->execute();
    $receitas = $sth->fetchAll();
    if($input['ordem'] == '1'){
      $this->logger->info("Requisição POST para url: '/receita/feed' bem sucedida! Feed exibido por ordem temporal para o usuário de id: ".$id);
    }else{
      $this->logger->info("Requisição POST para url: '/receita/feed' bem sucedida! Feed exibido por ranking para o usuário de id: ".$id);
    }
    return $this->response->withJson($receitas);
  });

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
    $this->logger->info("Requisição POST para url: '/receita/add' bem sucedida! Receita cadastrada: '".$input['titulo']."'.");
    return $this->response->withJson($input);
  });

  $app->get('/busca/[{query}]', function ($request, $response, $args) {
    $id = $_SESSION['uid'];
    //SELECT id FROM user WHERE id != 50 OR id != (select id_user_follow from user_relation where id_user = 50)
    $sth = $this->db->prepare("SELECT * FROM receita WHERE titulo LIKE :query AND id_user != '$id' ORDER BY titulo");
    $query = "%".$args['query']."%";
    $sth->bindParam("query", $query);
    $sth->execute();
    $busca = $sth->fetchAll();
    $this->logger->info("Requisição GET para url: '/receita/busca/".$args['query']."' bem sucedida! Exibindo lista de receitas encontradas!");
    return $this->response->withJson($busca);
  });

// retorna as receitas do usuário
  $app->get('/doChef', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM receita WHERE id_user=:id ORDER BY tempo DESC");
    $sth->bindParam("id", $_SESSION['uid']);
    $sth->execute();
    $receitas = $sth->fetchAll();
    $this->logger->info("Requisição GET para url: '/receita/doChef' bem sucedida! Receitas do usuário de id: ".$_SESSION['uid']." foram exibidas com sucesso!");
    return $this->response->withJson($receitas);
  });

// retorna uma receita especifica
  $app->get('/buscaId/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM receita WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $receita = $sth->fetchAll();
    $this->logger->info("Requisição GET para url: '/receita/buscaId/".$args['id']."' bem sucedida! Receita exibida com sucesso!");
    return $this->response->withJson($receita);
  });

  // retorna as avaliacoes (usuario e nota) de uma receita especifica
    $app->get('/avaliacoes/[{id}]', function ($request, $response, $args) {
      $sth = $this->db->prepare("SELECT us.nome, av.nota, av.texto, av.id FROM avaliacao AS av INNER JOIN user AS us ON av.id_user = us.id WHERE id_receita=:id ORDER BY av.tempo DESC");
      $sth->bindParam("id", $args['id']);
      $sth->execute();
      $avaliacoes = $sth->fetchAll();
      $this->logger->info("Requisição GET para url: '/receita/avaliacoes/".$args['id']."' bem sucedida! Avaliações de receita exibida com sucesso!");
      return $this->response->withJson($avaliacoes);
    });

    // retorna as avaliacoes (usuario e nota) de uma receita especifica
      $app->get('/resavaliacoes/[{id}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT us.nome, res.texto FROM res_comentario AS res INNER JOIN user AS us ON res.id_user = us.id WHERE id_comenta=:id ORDER BY res.tempo ASC");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $respostas = $sth->fetchAll();
        return $this->response->withJson($respostas);
      });

// retorna as quantidades de comentarios e avaliações
/*  $app->get('/quantAvalia/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT COUNT(av.nota) as quant_avalia, COUNT(av.texto) as quant_comments FROM avaliacao AS av INNER JOIN user AS us ON av.id_user = us.id WHERE id_receita=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $cont = $sth->fetchObject();
    $this->logger->info("Requisição GET para contar AVALIAÇÕES e/ou COMENTÁRIOS bem sucedida!");
    return $this->response->withJson($cont);
  }); */

/*
  $app->post('/addCountAval', function ($request, $response){
    $input = $request->getParsedBody();
    $this->logger->info("Requisição POST para alterar quantidade de AVALIAÇÕES e/ou COMENTÁRIOS de uma RECEITA bem sucedida! = '$input[ava_num]'");
    $sql = "UPDATE receita SET (ava_num='$input[ava_num]', comment_num='$input[comment_num]') WHERE id='$input[id_receita]'";
    $sth = $this->db->prepare($sql);
    $sth->execute();
    return $this->response->withJson($input);
  });*/
});

$app->group('/avaliacao', function() use ($app){

  // adiciona avaliacao e atualiza quantidade na receita
  $app->post('/add', function ($request, $response){
    $input = $request->getParsedBody();
    $sql = "INSERT INTO avaliacao (id_user, id_receita, nota, texto) VALUES (:id_user, :id_receita, :nota, :texto)";
    $sth = $this->db->prepare($sql);
    $sth->execute([
        ':id_receita' => $input['id_receita'],
        ':nota' => $input['nota'],
        ':texto' => $input['texto'],
        ':id_user' => $_SESSION['uid']
    ]);
    $input['id'] = $this->db->lastInsertId();

    //aprender como fazer um subrequest para esta função a seguir - realizar contagem de comentarios e notas da receita
    $sth3 = $this->db->prepare("SELECT COUNT(av.nota) as quant_avalia, COUNT(av.texto) as quant_comments FROM avaliacao AS av INNER JOIN user AS us ON av.id_user = us.id WHERE id_receita=".$input['id_receita']);
    $sth3->execute();
    $cont = $sth3->fetchObject();
    $dec_cont = json_encode($cont);
    $dec_cont2 = json_decode($dec_cont, true);

    //aprender como fazer um subrequest para esta função a seguir - atualizar numero de comentarios e notas
    if($input['texto'] & $input['nota']){
      $sql2 = "UPDATE receita SET ava_num=:ava_num, comment_num=:comment_num WHERE id=".$input['id_receita'];
      $sth2 = $this->db->prepare($sql2);
      $sth2->execute([
          ':ava_num' => $dec_cont2['quant_avalia'],
          ':comment_num' => $dec_cont2['quant_comments']
      ]);

      //aprender como fazer um subrequest para esta função a seguir - atualizar nota da receita
      $sum = $this->db->prepare("SELECT SUM(nota) as soma FROM avaliacao WHERE id_receita=".$input['id_receita']);
      $sum->execute();
      $sum2 = $sum->fetchObject();
      $sum3 = json_encode($sum2);
      $soma = json_decode($sum3, true);

      $media = $soma['soma']/$dec_cont2['quant_avalia'];


      $sql4 = "UPDATE receita SET nota=:nota WHERE id=".$input['id_receita'];
      $sth4 = $this->db->prepare($sql4);
      $sth4->execute([
          ':nota' => $media,
      ]);
    }else if($input['texto']){
      $sql2 = "UPDATE receita SET comment_num=:comment_num WHERE id=".$input['id_receita'];
      $sth2 = $this->db->prepare($sql2);
      $sth2->execute([
          ':comment_num' => $dec_cont2['quant_comments']
      ]);
    }else if($input['nota']){
      $sql2 = "UPDATE receita SET ava_num=:ava_num WHERE id=".$input['id_receita'];
      $sth2 = $this->db->prepare($sql2);
      $sth2->execute([
          ':ava_num' => $dec_cont2['quant_avalia'],
      ]);

      //aprender como fazer um subrequest para esta função a seguir - atualizar nota da receita
      $sum = $this->db->prepare("SELECT SUM(nota) as soma FROM avaliacao WHERE id_receita=".$input['id_receita']);
      $sum->execute();
      $sum2 = $sum->fetchObject();
      $sum3 = json_encode($sum2);
      $soma = json_decode($sum3, true);

      $media = $soma['soma']/$dec_cont2['quant_avalia'];


      $sql4 = "UPDATE receita SET nota=:nota WHERE id=".$input['id_receita'];
      $sth4 = $this->db->prepare($sql4);
      $sth4->execute([
          ':nota' => $media,
      ]);
    }

    $this->logger->info("Requisição POST para url: '/receita/avaliacao/add' bem sucedida! Avaliação do usuário de id: ".$_SESSION['uid']." foi inserida com sucesso na receita de id: ".$input['id_receita']);
    return $this->response->withJson($input);
  });

});
