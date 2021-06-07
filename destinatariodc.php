<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> Utilitarios Athenas - Novos usuários DC </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <h3 class="text-center"> Utilitarios Athenas - Document Center - Novo Usuário Externo </h3>   

        <?php

        //Conexão do DB
        require('conn.php');

        if (isset($_POST['codempresa'])) {
            $codEmpresa = $_POST['codempresa'];
            $nomeEmpresa = $_POST['nomeempresa'];
        } else {
            $codEmpresa = "Indefinido";
        }

        if (isset($_POST['codusuario'])) {
            $codUser = $_POST['codusuario']; 
        } else {
            $codUser = "Indefinido";
        }

        if (isset($_POST['adddocsdc'])) {
            $marcacaoUser = "Marcação OK";
        } else {
            $marcacaoUser = "Desmarcado";
        }

        //$codEmpresa = 9999;
        //$codUser = 8;
        $codAdmin = 1;
        $dataAtual = date("j-M-Y");
        $horaAtual = date("H:i:s");
        $contador = 0;

        //Qry para codigos de documentos de acordo com cod da empresa
        $query = $conn->query(" select distinct c.codigo
                                from tabdcdocumentos c
                                where c.codigoempresa = ".$codEmpresa."
                            ");

        //Retornando e monstando o INSERT
        while($registros = $query->fetch(PDO::FETCH_ASSOC)) {
            $contador++;
            $addUser = "INSERT INTO TABDCDESTINATARIOS ( CODIGODOCUMENTO, CODIGOUSUARIO, USOREG, DTREG, HORAREG) VALUES ( ".
            $registros["CODIGO"] .", ". 
            $codUser .", ". 
            $codAdmin .", '".
            $dataAtual ."', '".
            $horaAtual ."');"; 
            //echo "<br>";  
            //echo $addUser;
            $exeQry = $conn->query($addUser);
        }

        ?>

        <div>
            <figure class='text-center'>
                <blockquote class='blockquote'>
                    <?php echo "<p> Empresas selecionada: ".$codEmpresa." - ".$nomeEmpresa.".</p>"?>
                </blockquote>
                <figcaption class='blockquote-footer'>
                    <?php echo "O usuário ".$codUser." foi adicionado a ".$contador." documento(s)."?>
                </figcaption>
                <div>
                    <a href="adddestinatariodc.php" class="btn btn-primary stretched-link"> Voltar </a>
                </div>
            </figure>       
        </div>
    </body>
</html>        