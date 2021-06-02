<?php

	//HTML dos campos
	include '../html/camposAlteracao.html';

	//conectamos ao banco de dados
	$conn = new PDO('firebird:dbname=10.136.0.10:/athenas/database/athenas.fdb', 'SYSDBA', 'masterkey');
	
	//recebendo variaveis condicional ao preenchimento
	//$tarefasExecutor = '86';
	if (empty($_POST['codExeTarefa'])) {
		$tarefasExecutor = 'X1X2X3';
	} else {
		$tarefasExecutor = "SET d.codigoexecutor = ". $_POST['codExeTarefa'];
	}
	
	//recebendo codigo da tarefa
	//$tarefasCodigo = '68001,68013';
	//$tarefasCodigo = "and t.codigo in ( " . $_POST['codTarefa'] . " )";

	//recebendo codigo do processo
	//$tarefasProcesso = '65';
	if (empty($_POST['codProcesso'])) {
		$tarefasProcesso = 'X1X2X3';
	} else {
		$tarefasProcesso = "and t.codigoprocesso in (" . $_POST['codProcesso'] . ")";
	}

	//recebendo texto da pesquisa na descrição da tarefa
	//$tarefasDescricao = 'PA:05/2021';
	if (empty($_POST['descTarefa'])) {
		$tarefasDescricao = 'X1X2X3';
	} else {
		$tarefasDescricao = $_POST['descTarefa'];
		$tarefasDescricao = "%$tarefasDescricao%";
	}
	 
	//montamos a query da alteração
	$tarefasQryAlteracao = "
	
	UPDATE tabcontroletarefasdetalhe d
	".$tarefasExecutor."
	where d.idmaster in (   
						SELECT t.idmaster
						from  tabcontroletarefas t
						where t.status = 'A'
						and t.descricao like :consulta
						".$tarefasProcesso."
						)
	and d.STATUS = 'A'
	
	";

	$tarefasAlteracao = $conn->prepare($tarefasQryAlteracao);
	$tarefasAlteracao->bindValue(':consulta', $tarefasDescricao, PDO::PARAM_STR);
	$tarefasAlteracao->execute();
	 
	//retornamos todos os registros (fetchAll) em forma de uma lista de Objetos (FECH_OBJ)
	$tarefasQryRetorno = "
	
	SELECT d.idmaster, d.codigotarefa, d.codigosubtarefa, d.codigoexecutor, d.dataprevista, d.status
	from tabcontroletarefasdetalhe d
	where d.idmaster in (
						SELECT t.idmaster
						from  tabcontroletarefas t
						where t.status = 'A'
						and t.descricao like :consulta
						".$tarefasProcesso."
						)
	and d.STATUS = 'A'
	
	";

	$tarefasRetorno = $conn->prepare($tarefasQryRetorno);
	$tarefasRetorno->bindValue(':consulta', $tarefasDescricao, PDO::PARAM_STR);
	$tarefasRetorno->execute();

	$contagem = 0;

    while($registros = $tarefasRetorno->fetch(PDO::FETCH_ASSOC)) {
		$contagem++;
        echo '|-> IDMASTER = ' . $registros['IDMASTER'] . ' |-> CODIGO TAREFA = ' .$registros['CODIGOTAREFA']. ' |-> EXECUTOR = ' . $registros['CODIGOEXECUTOR'] ."<br>";
    }

	echo $contagem;
?>