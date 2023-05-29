<?php
    require 'database.php';
    if ( !empty($_POST)) {
		$cm = $_POST['cm'];

        $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE `hc_data` SET cm = ? WHERE id = 2";
		$q = $pdo->prepare($sql);
		$q->execute(array($cm));
		Database::disconnect();
    }
?>