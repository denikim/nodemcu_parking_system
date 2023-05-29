<?php
    require 'database.php';
    if ( !empty($_POST)) {
       // $id = $_POST['id'];
		$cm = $_POST['cm'];
		// insert data
        $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$sql = "INSERT INTO hc_data (id,cm) values(?, ?)";
		$sql = "UPDATE `hc_data` SET cm = ? WHERE id = 1";
		$q = $pdo->prepare($sql);
		$q->execute(array($cm));
		Database::disconnect();
    }
?>