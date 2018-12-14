<?php
session_start();
ob_start();
if (isset($_GET['id'])) {
    include_once 'model/funcionario.class.php';
    include_once 'dao/funcionariodao.class.php';
    $fDAO         = new FuncionarioDAO();
    $query        = "where idfuncionario = " . $_GET['id'];
    $funcionarios = $fDAO->filtrarFuncionario($query);
    $funcionario  = $funcionarios[0];
} else {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <title>Alterar Funcionário</title>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
   </head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Alterar Funcionario</h1>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Sistema GSM</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="dropdown">
                 <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Funcionario
                 <span class="caret"></span></button>
                 <ul class="dropdown-menu">
                    <li><a href="cadastro-funcionario.php">Cadastrar</a></li>
                    <li><a href="pesquisar-funcionario.php">Editar</a></li>
                 </ul>
              </div>
              <div class="dropdown">
                 <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Turma
                 <span class="caret"></span></button>
                 <ul class="dropdown-menu">
                    <li><a href="cadastro-turma.php">Cadastrar</a></li>
                    <li><a href="pesquisar-turma.php">Editar</a></li>
                 </ul>
              </div>
              <div class="dropdown">
                 <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Professor
                 <span class="caret"></span></button>
                 <ul class="dropdown-menu">
                    <li><a href="cadastro-professor.php">Cadastrar</a></li>
                    <li><a href="pesquisar-professor.php">Editar</a></li>
                 </ul>
              </div>
              <div class="dropdown">
                 <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Aluno
                 <span class="caret"></span></button>
                 <ul class="dropdown-menu">
                    <li><a href="cadastro-aluno.php">Cadastrar</a></li>
                    <li><a href="pesquisar-aluno.php">Editar</a></li>
                 </ul>
              </div>
        </nav>

        <form name="cadfunc" method="post" action="">
           <div class="form-group">
              <p>Nome Completo</p>
              <input type="text" name="txtnome" placeholder="Ex: João Silva" class="form-control" value="<?php
echo $funcionario->nome;
?>">
           </div>
           <div class="radio">
              <p>Sexo</p>
              <label class="radio-inline">
              <input type="radio" name="rdsexo" value="Masculino" <?php
if ($funcionario->sexo == 'Masculino') {
    echo "checked";
}
?>>Masculino</label>
              <label class="radio-inline">
              <input type="radio" name="rdsexo" value="Feminino" <?php
if ($funcionario->sexo == 'Feminino') {
    echo "checked";
}
?>>Feminino</label>
           </div>
           <div class="form-group">
              <p>Data de Nascimento</p>
              <input type="date" name="txtdatanasc" placeholder="Data de Nascimento" class="form-control" value="<?php
echo $funcionario->datanasc;
?>">
           </div>
           <div class="form-group">
              <p>Cargo</p>
              <input type="text" name="txtcargo" placeholder="Ex: Técnico em Informática" class="form-control" value="<?php
echo $funcionario->cargo;
?>">
           </div>
           <div class="form-group">
              <p>CPF</p>
              <input type="text" name="txtcpf" placeholder="Ex: 000.000.000-00" class="form-control" value="<?php
echo $funcionario->cpf;
?>">
           </div>
           <div class="form-group">
              <p>Endereço</p>
              <input type="text" name="txtendereco" placeholder="Ex: Rua A, 150" class="form-control" value="<?php
echo $funcionario->endereco;
?>">
           </div>
           <div class="form-group">
              <p>CEP</p>
              <input type="text" name="txtcep" placeholder="Ex: 00000-000" class="form-control"
              value="<?php
echo $funcionario->cep;
?>">
           </div>
           <div class="form-group">
              <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
              <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
           </div>
        </form>
        <?php

if (isset($_POST['alterar'])) {
    include_once "model/funcionario.class.php";
    include_once "dao/funcionariodao.class.php";
    include_once "util/padronizacao.class.php";
    include_once "util/validacao.class.php";
    include_once "util/cpfmuitoloco.class.php";

    $qtdErros = 0;
    if (!Validacao::validarNome($_POST['txtnome'])) {
        $qtdErros++;
        echo "<div class='alert alert-danger' role='alert'>
            Nome Inválido!
            </div>";
    }
    if (!CPFBolado::valida_cpf($_POST['txtcpf'])) {
        $qtdErros++;
        echo "<div class='alert alert-danger' role='alert'>
            CPF Inválido!
            </div>";
    }

    if (!Validacao::validarSexo($_POST['rdsexo'])) {
        $qtdErros++;
        echo "<div class='alert alert-danger' role='alert'>
            Sexo Inválido!
            </div>";
    }

    if ($qtdErros == 0) {

        $f                = new Funcionario();
        $f->idfuncionario = $funcionario->idfuncionario;
        $f->nome          = Padronizacao::padronizarMaiMin($_POST['txtnome']);
        $f->sexo          = $_POST['rdsexo'];
        $f->datanasc      = $_POST['txtdatanasc'];
        $f->cargo         = Padronizacao::padronizarMaiMin($_POST['txtcargo']);
        $f->cpf           = $_POST['txtcpf'];
        $f->endereco      = $_POST['txtendereco'];
        $f->cep           = $_POST['txtcep'];

        $fDAO = new FuncionarioDAO();
        $fDAO->alterarFuncionario($f);

        $_SESSION['msg'] = "Funcionário alterado com sucesso!";
        header("location:pesquisar-funcionario.php");
        unset($_POST);
    }
}
?>
      </div>
  </body>
</html>
