<meta http-equiv="Refresh" content="5" />

<?php  
	require 'database.php';
        $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$ip='172.20.10.3';
       // $ip='192.168.43.245';
       $ip='192.168.182.107';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/parking_slots.css">
</head>
<style>
    .styled-table {
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 300px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }
    .styled-table thead tr {
        background-color: #009879;
        color: #ffffff;
        text-align: left;
    }
    .styled-table th,
    .styled-table td {
        padding: 10px 10px;
    }
    .styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
    }

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr:last-of-type {
        border-bottom: 2px solid #009879;
    }
    .styled-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }
</style>
<body>

<?php
        $sql="SELECT `cm` FROM `hc_data`where id=1";
        foreach($pdo->query($sql) as $row){
            if($row['cm']<=7){
                $update0="UPDATE `hc_data` SET `is_occupied`='1' WHERE id=1";
                $q = $pdo->prepare($update0);
                $q->execute();
                echo'<img class="st" src="http://'.$ip.'/NodeMCU-parking-system/images/yellow.jpg">';
            }
            else{
                $update1="UPDATE `hc_data` SET `is_occupied`='0' WHERE id=1";
                $q = $pdo->prepare($update1);
                $q->execute(array());
            }
        }
        $sql1="SELECT `cm` FROM `hc_data`where id=2";
        foreach($pdo->query($sql1) as $row){
            if($row['cm']<=7){
                $update1="UPDATE `hc_data` SET `is_occupied`='1' WHERE id=2";
                $q = $pdo->prepare($update1);
                $q->execute(array());
                echo'<img class="nd" src="http://'.$ip.'/NodeMCU-parking-system/images/green.jpg">';
            }
            else{
                $update1="UPDATE `hc_data` SET `is_occupied`='0' WHERE id=2";
                $q = $pdo->prepare($update1);
                $q->execute(array());
            }
        }
        Database::disconnect();
            ?>
            <table class="styled-table">
    <thead>
        <tr>
            <th>place number</th>
            <th>distance</th>
            <th>occupation</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql0="SELECT `cm`,`id`,`is_occupied` FROM `hc_data`";
        foreach($pdo->query($sql0) as $row){
            echo '<tr class="active-row">';
            echo' <td>'.$row['id'].'</td>
            <td>'.$row['cm'].'</td>';
            if($row['is_occupied']==1){
                echo '<td>Occupied</td>';
            }
            else{
                echo '<td>Free</td>';
            }
            echo '</tr>';
        }
            ?>
    </tbody>
</table>
</body>


