<?php

	//conectamos ao banco de dados
	$conn = new PDO('firebird:dbname=10.136.0.10:/athenas/database/athenas.fdb', 'SYSDBA', 'masterkey');

	//Query para retornar usuários
	$qryUsuarios = $conn->query("Select * from tabcadusuarios u where u.vendedor = 0 and u.inativo = 0 order by u.nome asc");

	//Query para retornar empresas
	$qryEmpresas = $conn->query("select e.codigo, e.nome from tabempresas e where e.nome is not null order by e.nome asc");

	//Query para retorno de docmentos em branco
	$qryTabDCDocumentos = $conn->query("select d.codigoempresa, d.codigo, d.dataenvio, d.assunto from TABDCDOCUMENTOS d where d.idmaster is null");
	 
	//montamos e rodamos a query   
	//$query = $con->query("select * from tabcadusuarios");
	//$query->execute();
	 
	//retornamos todos os registros (fetchAll) em forma de uma lista de Objetos (FECH_OBJ)
	//$registros = $query->fetchAll(PDO::FETCH_OBJ);
			
	//percorremos a lista retornando item por item e imprimindo a propriedade que desejamos (neste caso: NOME)
	//foreach($registros as $r) {
	//	 echo $r->NOME . "<br>";
    //}

?>