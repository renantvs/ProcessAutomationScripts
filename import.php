<?php

require_once('conexao.php');

$arquivocsv = "planilha_teste.csv";

$row = 1;
$columns = [];

if (($handle = fopen("planilha_teste.csv", "r")) !== FALSE) {

    $sqlexcluir= 'TRUNCATE TABLE teste1';
    $stmt = $conn->prepare($sqlexcluir);  

    $stmt->execute();

    while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
        $total_columns = count($data);
        if (empty($columns)) {
            for ($index=0; $index < $total_columns; $index++) {
                $columns[$index] = $data[$index];
            }
            continue;
        }

        $row++;
        $dados=[];
        for ($c=0; $c < $total_columns; $c++) {
            $dados[$columns[$c]]= mb_convert_encoding($data[$c], 'UTF-8', 'Windows-1252');
        }


        $sqlinserir= 'INSERT INTO teste1 (CPF_USUARIO, NOME_USUARIO, EMAIL, 
        TELEFONE_CELULAR, MARCACAO_WHATSAPP, Perfil) VALUES (:cpf_usuario, 
        :nome_usuario, :email, :telefone_celular, :marcacao_whatsapp, :perfil)';
         
        $stmt = $conn->prepare($sqlinserir);    
        $stmt->bindValue(':cpf_usuario', $dados['CPF_USUARIO']);
        $stmt->bindValue(':nome_usuario', $dados['NOME_USUARIO']);
        $stmt->bindValue(':email', $dados['EMAIL']);
        $stmt->bindValue(':telefone_celular', $dados['TELEFONE_CELULAR']);
        $stmt->bindValue(':marcacao_whatsapp', $dados['MARCACAO_WHATSAPP']);
        $stmt->bindValue(':perfil', $dados['Perfil']);

        $stmt->execute();

    }

    $data_atual = new DateTime();
    $atualizado_em = $data_atual->format('Y-m-d H:i:s');

    $sqlupdate = "UPDATE teste1 SET atualizado_em = '$atualizado_em'";
    $stmt = $conn->prepare($sqlupdate);
    $stmt-> execute();


    $sqlupdatecpf= "UPDATE teste1 SET cpf_usuario = lpad(cpf_usuario, 11,'0')";
    $stmt= $conn-> prepare($sqlupdatecpf);
    $stmt-> execute();

    
    fclose($handle);

}

//TO DO: Verify command "CALL `planilhateste`.`move_base_sky_user`();"

echo "Atualização concluída!";

return;

?>