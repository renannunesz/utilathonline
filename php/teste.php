<?php
 
    //include '../html/camposPesquisa.html';
    include '../html/altDatasPrevistas.html';

    $conn = new PDO('firebird:dbname=10.136.0.10:/athenas/database/athenas.fdb', 'SYSDBA', 'masterkey');

    //$codTarefas = '68001,68013';
    if (empty($_POST['codTarefa'])) {
        $codTarefas = '';
        echo "Codigo das tarefas: " . $codTarefas .'<br>';
    } else {
        $codTarefas = "and t.codigo in ( " . $_POST['codTarefa'] . " )";
        echo "Codigo das tarefas: " . $codTarefas .'<br>';
    }
    
    //$txtPesquisa = 'PA:05/2021'; 
    if (isset($_POST['descTarefa'])) {
        $txtPesquisa = $_POST['descTarefa'];
        echo "Texto das tarefas: " . $txtPesquisa .'<br>';
    } else {
        $txtPesquisa = '%%';
        echo "Texto das tarefas: " . $txtPesquisa .'<br>';
    }

    //recebendo data para alteração no registro
    if (empty($_POST['dataTarefa'])) {
        $tarefasData = 'X1X2X3';
        echo "Data das tarefas: " . $tarefasData .'<br>';
    } else {
        $tarefasData = date("m/d/Y", strtotime($_POST['dataTarefa']));
        echo "Data das tarefas: " . $tarefasData .'<br>';
    }

    //echo $txtPesquisa . '<br>';
    /*
    $txtPesquisa = "%$txtPesquisa%";

    $qryConsulta = "
    
    SELECT d.idmaster, d.codigotarefa, d.codigosubtarefa, d.codigoexecutor, d.dataprevista, d.status
	from tabcontroletarefasdetalhe d
	where d.idmaster in (   
                            SELECT t.idmaster
                            from  tabcontroletarefas t
                            where t.status = 'A'
                            and t.descricao like :consulta
                            ".$codTarefas."
                        )
	and d.STATUS = 'A'

    ";

	$query3 = $conn->prepare($qryConsulta);

    $query3->bindValue(':consulta', $txtPesquisa, PDO::PARAM_STR);

	$query3->execute();

    while($registros3 = $query3->fetch(PDO::FETCH_ASSOC)) {
        
        echo 'IDMASTER = ' . $registros3['IDMASTER'] . ' | EXECUTOR = ' . $registros3['CODIGOEXECUTOR'] . ' | COD. TAREFA = ' . $registros3['CODIGOTAREFA'] ."<br>";
    }
    */

?>