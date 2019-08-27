<?php
require_once('classes/pessoa.php');
$pessoa = new Pessoa("crudpdo", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastro de Pessoas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    if (isset($_POST['cadastrar'])) {
        $nome = addslashes($_POST['nome']);
        $telefone = addslashes(($_POST['telefone']));
        $email = addslashes(($_POST['email']));

        // Verifica inputs vazios.
        if (!empty($nome) && !empty($telefone) && !empty($email)) {
            // Verifica se e-mail já está cadastrado.
            if (!$pessoa->cadastrar($nome, $telefone, $email)) {
                echo "E-mail já cadastrado.";
            }
        } else {
            echo "Preencha todos os campos.";
        }
    }
    ?>
    <section id="esquerda">
        <form action="" method="POST">
            <h2>Cadastrar pessoa</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome">
            <label for="telefone">Telefone</label>
            <input type="tel" name="telefone" id="telefone">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email">
            <input type="submit" value="Cadastrar" name="cadastrar">
        </form>
    </section>
    <section id="direita">
        <table>
            <tr id="titulo">
                <td>Nome</td>
                <td>Telefone</td>
                <td colspan="2">E-mail</td>
            </tr>
            <?php
            $listaPessoa = $pessoa->buscarDados();
            if (count($listaPessoa) > 0) // se tem pessoas cadastradas
            {
                for ($i = 0; $i < count($listaPessoa); $i++) {
                    echo "<tr>";
                    foreach ($listaPessoa[$i] as $indice => $pessoaDado) {
                        if ($indice != "ID") {
                            echo "<td>" . $pessoaDado . "</td>";
                        }
                    }
                    ?>
            <td>
                <a href="">Editar</a>
                <a href="index.php?id=<?php echo $listaPessoa[$i]['ID']; ?>" onClick="return confirm('Tem certeza que deseja excluir esta pessoa?')">Excluir</a>
            </td>
            <?php
                    echo "</tr>";
                }
                ?>
            <?php
            } else // não tem pessoas cadastradas
            {
                echo "Nenhuma pessoa cadastrada.";
            }
            ?>
            </tr>
        </table>
    </section>
</body>

</html>

<?php
if (isset($_GET['id'])) {
    $id = addslashes($_GET['id']);
    $pessoa->excluir($id);
    header("location: .");
}
?>