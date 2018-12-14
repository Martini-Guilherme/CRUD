<?php
session_start();
ob_start();
include_once "model/funcionario.class.php";
include_once "dao/funcionariodao.class.php";
include_once "util/padronizacao.class.php";
include_once "util/validacao.class.php";
include_once "util/cpfmuitoloco.class.php";
include_once "util/helper.class.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <title>Cadastro de Funcionário</title>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
   </head>
   <body>
      <div class="container">
         <h1 class="jumbotron bg-info">Cadastro de Funcionario</h1>
         <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">Sistema GSM</a>
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
               <input type="text" name="txtnome" placeholder="Ex: João Silva" class="form-control">
            </div>
            <div class="radio">
               <p>Sexo</p>
               <label class="radio-inline">
               <input type="radio" name="rdsexo" value="Masculino" checked>Masculino</label>
               <label class="radio-inline">
               <input type="radio" name="rdsexo" value="Feminino">Feminino</label>
            </div>
            <div class="form-group">
               <p>Data de Nascimento</p>
               <input type="date" name="txtdatanasc" placeholder="Data de Nascimento" class="form-control">
            </div>
            <div class="form-group">
               <p>Cargo</p>
               <input type="text" name="txtcargo" placeholder="Ex: Técnico em Informática" class="form-control">
            </div>
            <div class="form-group">
               <p>CPF</p>
               <input type="text" name="txtcpf" placeholder="Ex: 000.000.000-00" class="form-control">
            </div>
            <div class="form-group">
               <p>Endereço</p>
               <input type="text" name="txtendereco" placeholder="Ex: Rua A, 150" class="form-control">
            </div>
            <div class="form-group">
               <p>CEP</p>
               <input type="text" name="txtcep" placeholder="Ex: 00000-000" class="form-control">
            </div>
            <div class="form-group">
               <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary">

               <script>
                function limpa_campos(){
                  document.getElementById('txtnome').value = "";
                  document.getElementById('rdsexo').value = "Masculino";
                  document.getElementById('txtdatanasc').value = "";
                  document.getElementById('txtcargo').value = "";
                  document.getElementById('txtcpf').value = "";
                  document.getElementById('txtendereco').value = "";
                  document.getElementById('txtcep').value = "";
                }
              </script>
              <form>
                <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger" onclick="limpa_campos">
              </form>


            </div>
         </form>
         <?php
if (isset($_SESSION['msg'])) {
    Helper::alert($_SESSION['msg']);
    Helper::h2($_SESSION['msg']);
    unset($_SESSION['msg']);
}

if (isset($_POST['cadastrar'])) {


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

        $f           = new Funcionario();
        $f->nome     = Padronizacao::padronizarMaiMin($_POST['txtnome']);
        $f->sexo     = $_POST['rdsexo'];
        $f->datanasc = $_POST['txtdatanasc'];
        $f->cargo    = Padronizacao::padronizarMaiMin($_POST['txtcargo']);
        $f->cpf      = $_POST['txtcpf'];
        $f->endereco = $_POST['txtendereco'];
        $f->cep      = $_POST['txtcep'];


        $fDAO = new FuncionarioDAO();
        $fDAO->cadastrarFuncionario($f);
        $_SESSION['msg'] = "Funcionário cadastrado com sucesso!";
        header("location:cadastro-funcionario.php");
        unset($_POST);
    }
}

?>
      </div>
   </body>
</html>
