<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MtdsT.I. - Utilitários</title>
    <!-- Bootstrap core CSS-->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin.css" rel="stylesheet">
    <!-- Icone da Métodos -->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

  </head>

  <body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
      <a class="navbar-brand mr-1" href="index.html">Métodos - Utilitários</a>
      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>
    </nav>
    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">


        <li class="nav-item active">
        <!-- Sidebar EQUIPES --> 
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>Opções</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Tarefas Athenas:</h6>
            <a class="dropdown-item" href="#">Ajustar Responsáveis</a>
            <a class="dropdown-item" href="#">Ajustar Vencimentos</a>
            <div class="dropdown-divider"></div>
            <!-- Espaço para outra divisão da sidebar aqui abaixo-->
            <!-- Aqui -->
          </div>
        </li>        
        
      </ul>

      <div id="content-wrapper">
        <div class="container-fluid">
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#"> Inicio </a>
            </li>
          </ol>

          
          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              Utilitários - Métodos Contabilidade
              <div class="card-body">
                <form action="ajstresp.php" method="GET">               
                  ID Master: <input type:"text" name='idmaster'> 
                  Cod. Tarefa: <input type:"text" name='codtarefa'> 
                  Executor: <input type:"text" name='executor'> 
                  Status: <input type:"text" name='status'>
                  Cod. Processo: <input type:"text" name='codprocesso' required> 
                  Assunto: <input type:"text" name='assunto'> 
                  Descrição: <input type:"text" name='descricao'>
                  <br>
                  <input type="submit" value="Pesquisar">
                </form>
                <br>
                <input type="button" href="#" data-toggle="modal" data-target="#editarModal" value="Alterar Responsável em Lote">
              </div>
            </div>
          </div>

          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>ID Master</th>           <!-- 1 coluna -->
                        <th>Cod. Tarefa</th>          <!-- 2 coluna -->
                        <th>Cod. Sub Tarefa</th>       <!-- 3 coluna -->
                        <th>Cod. Executor</th>       <!-- 4 coluna -->
                        <th>Data Prevista</th>          <!-- 5 coluna -->
                        <th>Cod. Cliente</th>    <!-- 6 coluna -->
                        <th>Nome Cliente</th>    <!-- 7 coluna -->
                        <th>Assunto Tarefa</th>    <!-- 8 coluna -->
                        <th>Descrição Tarefa</th>    <!-- 8 coluna -->
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>ID Master</th>           <!-- 1 coluna -->
                        <th>Cod. Tarefa</th>          <!-- 2 coluna -->
                        <th>Cod. Sub Tarefa</th>       <!-- 3 coluna -->
                        <th>Cod. Executor</th>       <!-- 4 coluna -->
                        <th>Data Prevista</th>          <!-- 5 coluna -->
                        <th>Cod. Cliente</th>    <!-- 6 coluna -->
                        <th>Nome Cliente</th>    <!-- 7 coluna -->
                        <th>Assunto Tarefa</th>    <!-- 8 coluna -->
                        <th>Descrição Tarefa</th>    <!-- 8 coluna -->
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                      //$codProcesso = $_GET['codprocesso'];

                      if (isset( $_GET['codprocesso'])) {
                        $codProcesso = "t.codigoprocesso = " . $_GET['codprocesso'];
                      } else {
                        $codProcesso = "t.codigoprocesso <> 0";
                      }

                      if (isset ($_GET['descricao'])) {
                        $descProcesso = "t.descricao like " . $_GET['assunto'];
                      } else {
                        $descProcesso = "t.descricao like '%%' ";
                      }
                      
                      $con = new PDO('firebird:dbname=10.136.0.10:/athenas/database/athenas.fdb', 'SYSDBA', 'masterkey');
                      //montamos e rodamos a query   
                      $query = $con->query(" select d.idmaster, d.codigotarefa, d.codigosubtarefa, d.codigoexecutor, d.dataprevista, t.codigocliente, p.nome, t.assunto
                      from tabcontroletarefasdetalhe d
                      left join tabcontroletarefas t on d.codigotarefa = t.codigo
                      left join tabpessoas p on t.codigocliente = p.codigo
                      where ".$codProcesso." and ".$descProcesso." and d.status = 'A' ");
                      $query->execute();
                      //retornamos todos os registros (fetchAll) em forma de uma lista de Objetos (FECH_OBJ)
                      $registros = $query->fetchAll(PDO::FETCH_OBJ);
                          
                      //percorremos a lista retornando item por item e imprimindo a propriedade que desejamos (neste caso: NOME)
                      foreach($registros as $r) {
                        echo ' 
                          <tr>
                            <td>'. $r->IDMASTER . '</td>
                            <td>'. $r->CODIGOTAREFA . '</td>
                            <td>'. $r->CODIGOSUBTAREFA . '</td>
                            <td>'. $r->CODIGOEXECUTOR . '</td>
                            <td>'. $r->DATAPREVISTA . '</td>
                            <td>'. $r->CODIGOCLIENTE . '</td>
                            <td>'. $r->NOME . '</td>
                            <td>'. $r->ASSUNTO . '</td>
                          </tr>';
                        }
                    ?>

                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer small text-muted">Métodos Tecnologia - 2018</div>
          </div>

        </div>

        <!-- Modal-->
        <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alteração de responsável em lote</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form action="ajstresp.php" method="GET">
                <div class="modal-body">
                    Informe os campos de referência e em seguida, o novo responsável. Essa alteração vai afetar somente as tarefas que estão em abertas. <br><br>
                    Descrição: <input type="text" name='executor' required> <br><br>
                    Codigo Processo: <input type="text" name='codprocesso' required> <br><br>
                    <b>Novo Responsável: </b>
                        <select required>
                          <option value=""></option>
                          <option value="Renan">Renan</option>
                          <option value="Renan">José Carlos</option>
                          <option value="Renan">Helio</option>
                          <option value="Renan">Glauciene</option>
                          <option value="Renan">Alexandre</option>
                          <option value="Renan">Gilmara</option>
                        </select>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>                   
                  <input class="btn btn-primary" type="submit" value="Salvar">               
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © 2018</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin.min.js"></script>
    <!-- Demo scripts for this page-->
    <script src="../js/demo/datatables-demo.js"></script>
    <script src="../js/demo/chart-area-demo.js"></script>

  </body>

</html>
