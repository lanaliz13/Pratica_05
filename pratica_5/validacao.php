<?php
$diretorioDestino = "uploads/";

if (!is_dir($diretorioDestino)) {
    mkdir($diretorioDestino, 0755, true);
}

$arquivoDestino   = $diretorioDestino . basename($_FILES["arquivoParaEnviar"]["name"]);
$uploadOk         = 1;

$tipoArquivo      = strtolower(pathinfo($arquivoDestino, PATHINFO_EXTENSION));

if (isset($_POST["enviar"])) {
    $check = getimagesize($_FILES["arquivoParaEnviar"]["tmp_name"]);
    if ($check === false) {
        echo "Arquivo não é uma imagem.<br>";
        $uploadOk = 0;
    } else if (file_exists($arquivoDestino)) {
        echo "Desculpe, o arquivo já existe.<br>";
        $uploadOk = 0;
    } else if ($_FILES["arquivoParaEnviar"]["size"] > 500000) {
        echo "Desculpe, seu arquivo é muito grande.<br>";
        $uploadOk = 0;
    } else if (
        $tipoArquivo !== "jpg" &&
        $tipoArquivo !== "png" &&
        $tipoArquivo !== "jpeg" &&
        $tipoArquivo !== "gif" &&
        $tipoArquivo !== "tiff"
    ) {
        echo "Desculpe, apenas arquivos JPG, JPEG, PNG, TIFF e GIF são permitidos.<br>";
        $uploadOk = 0;
    } else {
        // Aqui só chega se nenhuma das condições acima falhou
        if (move_uploaded_file($_FILES["arquivoParaEnviar"]["tmp_name"], $arquivoDestino)) {
            echo "O arquivo \"" . htmlspecialchars(basename($_FILES["arquivoParaEnviar"]["name"])) . "\" foi enviado com sucesso.<br>";
            echo "<br><strong>Nome:</strong> " . htmlspecialchars($_POST["nome"]) . "<br>";
            echo "<strong>E-mail:</strong> " . htmlspecialchars($_POST["email"]) . "<br>";
            echo "<strong>Imagem enviada:</strong><br><img src='" . $arquivoDestino . "' width='200'><br>";
        } else {
            echo "Desculpe, ocorreu um erro ao enviar seu arquivo.<br>";
        }
    }
} else {
    echo "Requisição inválida.";
}

?>
