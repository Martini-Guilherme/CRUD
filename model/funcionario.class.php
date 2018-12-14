<?php
class Funcionario
{

    private $idFuncionario;
    private $nome;
    private $sexo;
    private $datanasc;
    private $cargo;
    private $cpf;
    private $endereco;
    private $cep;

    public function __construct()
    {
    }
    public function __destruct()
    {
    }

    public function __get($a)
    {
        return $this->$a;
    }
    public function __set($a, $v)
    {
        $this->$a = $v;
    }

    public function __toString()
    {
        return nl2br("Nome: $this->nome
                  Sexo: $this->sexo
                  Data nascimento: $this->datanasc
                  CPF: $this->cpf
                  Cargo: $this->cargo
                  Endereço: $this->endereco
                  CEP: $this->cep");

    }
}
