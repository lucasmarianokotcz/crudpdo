<?php

class Pessoa
{
    private $db;

    //---------------------------CONEXÃO---------------------------
    public function __construct($dbname, $host, $user, $senha)
    {
        try {
            $this->db = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $user, $senha);
        } catch (PDOException  $e) {
            echo "Erro com banco de dados: " . $e->getMessage();
        }
    }

    //---------------------------SELECT---------------------------
    public function buscarDados()
    {
        $resultado = array();
        $cmd = $this->db->query("SELECT * FROM pessoa ORDER BY
        NOME");
        $resultado = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //---------------------------INSERT---------------------------
    public function cadastrar($nome, $telefone, $email)
    {
        // Verifica se já existe uma pessoa cadastrada com o e-mail informado.
        $cmd = $this->db->prepare("SELECT ID FROM pessoa WHERE
        EMAIL = :EMAIL");
        $cmd->bindValue(":EMAIL", $email);
        $cmd->execute();

        if ($cmd->rowCount() > 0) // e-mail já existe
        {
            return false;
        } else // e-mail não foi cadastrado anteriormente
        {
            $cmd = $this->db->prepare("INSERT INTO pessoa(NOME, TELEFONE, EMAIL)
            VALUES (:NOME, :TELEFONE, :EMAIL)");
            $cmd->bindValue(":NOME", $nome);
            $cmd->bindValue(":TELEFONE", $telefone);
            $cmd->bindValue(":EMAIL", $email);
            $cmd->execute();
            return true;
        }
    }

    //---------------------------DELETE---------------------------
    public function excluir($id)
    {
        $cmd = $this->db->prepare("DELETE FROM pessoa WHERE
        ID = :ID");
        $cmd->bindValue(":ID", $id);
        $cmd->execute();
    }
}
