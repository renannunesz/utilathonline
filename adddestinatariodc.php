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

        <div>
            <?php require('conn.php'); //Conexão do DB ?>

            <form action="adddestinatariodc.php" method="get" id="formEmpesa">

                <div class="form-floating">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name='empresa' required>
                        <option selected></option>
                        <?php
                        while($regTabEmpresas = $qryEmpresas->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value=".$regTabEmpresas['CODIGO']."|".$regTabEmpresas['NOME'].">".$regTabEmpresas['NOME']." - ".$regTabEmpresas['CODIGO']."</option>";
                        }
                        ?>
                    </select>
                    <label for="floatingSelect"> Empresa - Codigo </label>
                    <input class="btn btn-secondary" type='submit' name='submit' value='Consultar Documentos'> 
                </div>
                
            </form>   

            <form action="destinatariodc.php" method="POST" id="formUser">
                <?php
                if (isset($_GET['empresa'])) {
                    $dadosEmpresa = explode('|',$_GET['empresa']);
                    echo "
                        <input type='hidden' name='codempresa' value=".$dadosEmpresa[0].">
                        <input type='hidden' name='nomeempresa' value=".$dadosEmpresa[1].">
                    ";
                }                 

                ?>
                <div id="seleciona_usuario">

                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name='codusuario' required>
                            <option selected></option>
                            <?php
                            while($regTabUsuarios = $qryUsuarios->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value=".$regTabUsuarios['CODIGO'].">".$regTabUsuarios['NOME']."</option>";
                            }
                            ?>
                        </select>
                        <label for="floatingSelect"> Usuário </label>
                        <input class="btn btn-secondary" type='submit' name='submit' value='Salvar Novo Usuário'>
                    </div>
                    
                </div>                    

            </form>

            <div>
                <div>
                    <figure class='text-center'>
                        <blockquote class='blockquote'>
                            <?php
                
                            if (isset($_GET['empresa'])) {
                                $dadosEmpresa = explode('|',$_GET['empresa']);
                                $codEmpresa = $dadosEmpresa[0];
                                $nomeEmpresa = $dadosEmpresa[1];  

                                $qryTabDCDocumentos = $conn->query("select d.codigoempresa, d.codigo, d.dataenvio, d.assunto 
                                from TABDCDOCUMENTOS d
                                WHERE d.codigoempresa = ". $codEmpresa );
                                
                                echo "
                                    <p> Empresas selecionada: ".$codEmpresa." - ".$nomeEmpresa.".</p>
                                ";                         
                            } else {
                                $qryTabDCDocumentos = $conn->query("select d.codigoempresa, d.codigo, d.dataenvio, d.assunto 
                                from TABDCDOCUMENTOS d
                                where d.idmaster is null");
                            } 

                            ?>
                        </blockquote>
                        <figcaption class='blockquote-footer'>
                            O destinatário será adicionado aos documentos mostrados.
                        </figcaption>
                    </figure>       
                </div>

                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Codigo Empresa</th>
                            <th>Codigo Documento</th>
                            <th>Data Envio</th>
                            <th>Assunto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contInterações = 0;
                        while($regTabDCDocumentos = $qryTabDCDocumentos->fetch(PDO::FETCH_ASSOC)) {
                            $contInterações++;
                            echo "
                            <tr>
                                <td>". $regTabDCDocumentos['CODIGOEMPRESA'] ."</td>
                                <td>". $regTabDCDocumentos['CODIGO'] ."</td>
                                <td>". $regTabDCDocumentos['DATAENVIO'] ."</td>
                                <td>". $regTabDCDocumentos['ASSUNTO'] ."</td>
                            </tr>
                            ";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>