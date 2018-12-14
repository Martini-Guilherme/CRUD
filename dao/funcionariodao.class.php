<?php
require_once "conexaobanco.class.php";
class FuncionarioDAO
{

    private $conexao = null;

    public function __construct()
    {
        $this->conexao = ConexaoBanco::getInstance();
    }

    public function __destruct()
    {
    }

    public function cadastrarFuncionario($f)
    {
        try {

            $stat = $this->conexao->prepare("insert into funcionario(idfuncionario,nome,sexo,datanasc,cargo,cpf,endereco,cep)
      values(null,?,?,?,?,?,?,?)");

            $stat->bindValue(1, $f->nome);
            $stat->bindValue(2, $f->sexo);
            $stat->bindValue(3, $f->datanasc);
            $stat->bindValue(4, $f->cargo);
            $stat->bindValue(5, $f->cpf);
            $stat->bindValue(6, $f->endereco);
            $stat->bindValue(7, $f->cep);

            $stat->execute();

        }
        catch (PDOException $e) {
            echo "Erro ao cadastrar funcionário! " . $e;
        }
    }

    public function buscarFuncionario()
    {
        try {
            $stat  = $this->conexao->query("select * from funcionario");
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Funcionario');
            return $array;
        }
        catch (PDOException $e) {
            echo "Erro ao buscar funcionário! " . $e;
        }
    }

    public function deletarFuncionario($id)
    {
        try {
            $stat = $this->conexao->prepare("delete from funcionario where idfuncionario = ?");
            $stat->bindValue(1, $id);
            $stat->execute();
        }
        catch (PDOException $e) {
            echo "Erro ao excluir! " . $e;
        }
    }

    public function filtrarFuncionario($query)
    {
        try {
            $stat  = $this->conexao->query("select * from funcionario " . $query);
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Funcionario');
            return $array;

        }
        catch (PDOException $e) {
            echo "Erro ao filtrar funcionario!" . $e;
        }

    }

    public function alterarFuncionario($f)
    {
        try {
            $stat = $this->conexao->prepare("update funcionario set nome=?, sexo=?, datanasc=?, cargo=?, cpf=?, endereco=?, cep=? where idfuncionario=?");

            $stat->bindValue(1, $f->nome);
            $stat->bindValue(2, $f->sexo);
            $stat->bindValue(3, $f->datanasc);
            $stat->bindValue(4, $f->cargo);
            $stat->bindValue(5, $f->cpf);
            $stat->bindValue(6, $f->endereco);
            $stat->bindValue(7, $f->cep);
            $stat->bindValue(8, $f->idfuncionario);
            $stat->execute();

        }
        catch (PDOException $e) {
            echo "Erro ao alterar funcionário! " . $e;
        }
    }
}
