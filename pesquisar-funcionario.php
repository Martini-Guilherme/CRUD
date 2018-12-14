<!DOCTYPE html>
<html lang="pt-br">
<html lang="pt-br">
   <head>
      <title>Buscar Funcionário</title>
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

    <h2>Pesquisa de funcionários!</h2>

    <form name="pesquisafunc" method="post" action="">
      <div class="row">
      <div class="form-group col-md-6">
        <input type="text" name="txtfiltro" placeholder="Digite o que deseja buscar" class="form-control animated">
      </div>
      <div class="form-group col-md-6">
        <select class="form-control" name="selfiltro">
          <option value="selecione">Selecione</option>
          <option value="codigo">ID Funcionário</option>
          <option value="nome">Nome</option>
          <option value="cargo">Cargo</option>
        </select>
        </div>
      </div>

      <div class="form-group" >
        <input type="submit" name="pesquisar" value="Pesquisar" class="form-control animated">
      </div>

    </form>

    <?php
if (isset($_SESSION['msg'])) {
    Helper::alert($_SESSION['msg']);
    Helper::h2($_SESSION['msg']);
    unset($_SESSION['msg']);
}

if (isset($_POST['pesquisar'])) {
    $filtro   = $_POST['selfiltro'];
    $pesquisa = $_POST['txtfiltro'];
    $qtdErro  = 0;
    if ($filtro == 'selecione' || $pesquisa == "") {
        $fs = $fDAO->buscarFuncionario();
        $qtdErro++;
    }

    if ($qtdErro == 0) {
        $query = "";
        if ($filtro == 'codigo') {
            $query = "where idfuncionario = " . $pesquisa;
        } else if ($filtro == 'nome') {
            $query = "where nome = '" . $pesquisa . "'";
        } else if ($filtro == 'cargo') {
            $query = "where cargo = '" . $pesquisa . "'";
        }
        $fs = $fDAO->filtrarFuncionario($query);
    }
}


if (count($fs) == 0) {
    echo "<h2>Tem nada aqui!!</h2>";
    die();
}
?>
    <div class="table-responsive">
      <table class="table table-striped table-bordered
                    table-hover table-condensed">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Data Nascimento</th>
            <th>Cargo</th>
            <th>CPF</th>
            <th>Endereço</th>
            <th>CEP</th>
            <th>Excluir</th>
            <th>Alterar</th>
          </tr>
        </thead>

        <tfoot>
          <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Data Nascimento</th>
            <th>Cargo</th>
            <th>CPF</th>
            <th>Endereço</th>
            <th>CEP</th>
            <th>Excluir</th>
            <th>Alterar</th>
          </tr>
        </tfoot>

        <tbody>
          <?php
foreach ($fs as $floco) {
    echo "<tr>";
    echo "<td>$floco->idfuncionario</td>";
    echo "<td>$floco->nome</td>";
    echo "<td>$floco->datanasc</td>";
    echo "<td>$floco->cargo</td>";
    echo "<td>$floco->cpf</td>";
    echo "<td>$floco->endereco</td>";
    echo "<td>$floco->cep</td>";
    echo "<td><a href='pesquisar-funcionario.php?id=$floco->idfuncionario'><button type='button' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span> Excluir</button></a></td>";
    echo "<td><a href='alterar-funcionario.php?id=$floco->idfuncionario'><button type='button' class='btn btn-info'><span class='glyphicon glyphicon-remove'></span> Alterar</button> </a></td>";
    echo "</tr>";
}
?>
        </tbody>
      </table>
    </div>
  </div>
  <?php
if (isset($_GET['id'])) {
    $fDAO->deletarFuncionario($_GET['id']);
    $_SESSION['msg'] = "Funcionário excluido com sucesso!";
    header("location:pesquisar-funcionario.php");
    unset($_GET['id']);
}
?>
</body>
</html>
