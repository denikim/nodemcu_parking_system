<?php  
    include 'header.php';
?>
<body>
    <div class="select-menu">
        <div class="select-btn">
            <span class="sBtn-text">Select your option</span>
            <i class="bx bx-chevron-down"></i>
        </div>
        <ul class="options">
        <?php
        $city_sql="SELECT `name` FROM `city`";
        foreach($pdo->query($city_sql) as $row){
            echo 
            '<a style="text-decoration: none" href="parking_area.php">
            <li class="option">
                    <i class="bx bx-current-location"></i>
                    <span class="option-text">'.$row['name'].'</span>
            </li> </a>';
        }
            ?>
        </ul>
    </div>
    <script src="./js/script.js"></script>
</body>


