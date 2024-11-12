<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Imagem</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Inserir Nova Postagem</h1>
        <form action="inserir_imagem.php" method="POST" enctype="multipart/form-data">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" required>
            <label for="imagem">Imagem</label>
            <input type="file" name="imagem">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" rows="4"></textarea>
            <input type="submit" value="Inserir Postagem">
        </form>
        <div class="return-button">
            <button><a href="exibir_imagens.php" class="link">Ver Postagens</a></button>
        </div>
    </div>
</body>
</html>
<?php

?>

<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sapos";
$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $descricao = $_POST["descricao"];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imagem"]["name"]);
    $path_imagem = NULL;

    if (!empty($_FILES["imagem"]["name"]) && move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
        $path_imagem = $target_file;
    }

    $sql = "INSERT INTO post (titulo, path_imagem, descricao) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $titulo, $path_imagem, $descricao);

    if ($stmt->execute()) {
        echo "<p class='success'>Postagem inserida com sucesso!</p>";
    } else {
        echo "<p class='error'>Erro ao inserir postagem: " . $conn->error . "</p>";
    }
    $stmt->close();
}
$conn->close();
?>
