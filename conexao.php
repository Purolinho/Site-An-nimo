<?php

    $host = "localhost";
    $nome = "root";
    $password = "";
    $nomeSQL = "anonimo";

    $ConexaoSQL = mysqli_connect($host, $nome, $password, $nomeSQL);

    echo
    "<div class='voltar'><p>Deseja escrever mais algumas mensagens?</p> <br> 
    <a href='index.html'>Sim</a>
    </div>";

    if($ConexaoSQL != true){
        die('nao foi possivel estabelecer a conexao ao banco de dados, porfavor contate o administrador');
    } else {
        
    $txt = $_GET["txt"];

    //conferir se foi escrito algo no texto
    if(empty($txt)) {
        echo "<div class='top'<h1>você não digitou nada :( </h1>";
    } else {
        echo "<div class='top'><h1> Obrigado por ter escrito sua mensagem :) </h1></div>";
        echo "<div class='top'><h2> Ultimas mensagens enviadas: </h2></div>";


        $ConferindoDados = "SELECT texto FROM escritas WHERE texto = '$txt'";
        $DadosChecados = $ConexaoSQL->query($ConferindoDados);

        if($verificação = mysqli_num_rows($DadosChecados) >= 1) {
            echo "<div class='top'<h4>Você ja digitou isto antes, ou alguem ja digitou isso! Vamos ser mais criativos da proxima vez</h4>";
        } else {
            echo "<div class='top'<h4>Original o seu texto, nínguem escreveu o mesmo que você ainda :)</h4>";
            $EnviandoDados = mysqli_query($ConexaoSQL, "INSERT INTO escritas(texto) VALUES ('$txt')");
        }
    }
    //coletar dado especifico da tabela
    $coletaDados = $ConexaoSQL->query("SELECT id,texto FROM escritas ORDER BY id desc LIMIT 6");
    while($dados = mysqli_fetch_assoc($coletaDados)) {
        echo "<div class='mensagens'><p>$dados[texto]</p></div>";
    }
}


    //deletar dados antigos
    $teste1 = "SELECT texto FROM escritas";
    $teste1 = $ConexaoSQL->query($teste1);

    if(mysqli_num_rows($teste1) > 6) {
        
        $resultado= mysqli_query($ConexaoSQL, "SELECT MIN(id) AS valor_minimo FROM escritas");
        $linha = mysqli_fetch_assoc($resultado);
        $minimo = $linha['valor_minimo'];

        $deletar = mysqli_query($ConexaoSQL, "DELETE FROM escritas WHERE id=$minimo");



        

        
    }



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagens</title>
    <link rel="stylesheet" href="mensagem.css?v=<?php echo time(); ?>">
</head> 
<body>


</body>
</html>