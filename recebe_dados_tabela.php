<?php

$arquivo_name = "planilha_teste.csv";
$caminho = "C:/wamp64/www/projeto/scriptinseredados/";
$abre_arquivo = $caminho.$arquivo_name;

if (($arquivo = fopen($abre_arquivo, "r")) !== FALSE) {
    while (($linha = fgetcsv($arquivo, 1000, ";")) !== FALSE) {
        $cpf_usuario = $linha[0];
        $nome_usuario = $linha[1];
        $email = $linha[2];
        $telefone_celular = $linha[3];
        $marcacao_whatsapp = $linha[4];
        $perfil = $linha[5];
    }
    fclose($arquivo);
}
?>