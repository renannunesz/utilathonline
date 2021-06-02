<?php

	//conectamos ao banco de dados
	$conn = new PDO('firebird:dbname=10.136.0.10:/athenas/database/athenas.fdb', 'SYSDBA', 'masterkey');

	//recebendo variaveis condicional ao preenchimento

	//recebendo codigo do executor
	//$tarefasExecutor = '86';
	if (empty($_POST['codExeTarefa'])) {
		$tarefasExecutor = '';
	} else {
		$tarefasExecutor = "SET d.codigoexecutor = ". $_POST['codExeTarefa'];
	}

	//recebendo codigo da tarefa
	//$tarefasCodigo = '68001,68013';
	if (empty($_POST['codTarefa'])) {
		$tarefasCodigo = '';
	} else {
		$tarefasCodigo = "and t.codigo in ( " . $_POST['codTarefa'] . " )";
	}

	//recebendo texto da pesquisa na descrição da tarefa
	//$tarefasDescricao = 'PA:05/2021';
	if (empty($_POST['descTarefa'])) {
		$tarefasDescricao = '%%';
	} else {
		$tarefasDescricao = $_POST['descTarefa'];
	}

	$tarefasDescricao = "%$tarefasDescricao%";	
	 
	//retornamos todos os registros (fetchAll) em forma de uma lista de Objetos (FECH_OBJ)
	$tarefasQryRetorno = "
	
	SELECT d.idmaster, d.codigotarefa, d.codigosubtarefa, d.codigoexecutor, d.dataprevista, d.status
	from tabcontroletarefasdetalhe d
	where d.idmaster in (
						SELECT t.idmaster
						from  tabcontroletarefas t
						where t.codigo in ( ".$tarefasCodigo." )
						and t.descricao like :consulta
						)
	and d.STATUS = 'A'
	
	";

	$tarefasRetorno = $conn->prepare($tarefasQryRetorno);
	$tarefasRetorno->bindValue(':consulta', $tarefasDescricao, PDO::PARAM_STR);
	$tarefasRetorno->execute();

    while($registros = $tarefasRetorno->fetch(PDO::FETCH_ASSOC)) {
        echo 'IDMASTER = ' . $registros['IDMASTER'] . ' CODIGO TAREFA = ' .$registros['CODIGOTAREFA']. ' EXECUTOR = ' . $registros['CODIGOEXECUTOR'] ."<br>";
    }

	include 'teste.php';

?>