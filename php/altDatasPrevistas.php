<?php

	//HTML dos campos
	include '../html/altDatasPrevistas.html';

	//conectamos ao banco de dados
	$conn = new PDO('firebird:dbname=10.136.0.10:/athenas/database/athenas.fdb', 'SYSDBA', 'masterkey');
	
	//recebendo variaveis condicional ao preenchimento
	if (empty($_POST['codProcesso'])) {
		$tarefasProcesso = 'X1X2X3';
	} else {
		$tarefasProcesso = $_POST['codProcesso'];
	}

	//recebendo texto da pesquisa na descrição da tarefa
	if (empty($_POST['descTarefa'])) {
		$tarefasDescricao = 'X1X2X3';
	} else {
		$tarefasDescricao = $_POST['descTarefa'];
		$tarefasDescricao = "%$tarefasDescricao%";
	}

    //recebendo data para alteração no registro
    if (empty($_POST('dataTarefa'))) {
        $tarefasData = 'X1X2X3';
    } else {
        $tarefasData = $_POST('dataTarefa');
    }
	 
	//montamos a query da alteração
	$tarefasQryAlteracao = "

    update tabcontroletarefasdetalhe d
    set d.dataprevista = ".$tarefasData."
    where d.idmaster in (
                        select IDMASTER
                        from TABCONTROLETAREFAS t
                        where t.status = 'A'
                        and t.descricao like :consulta
                        and t.codigoprocesso = ".$tarefasProcesso."
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
						and t.codigoprocesso = ".$tarefasProcesso."
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