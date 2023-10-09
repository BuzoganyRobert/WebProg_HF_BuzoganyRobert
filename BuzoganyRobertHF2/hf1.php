<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table width="100px" border="1px" cellspacing="0px">
        <?php
        $n=10;
        function szorzotabla(int $szam){
        
          for($i=1;$i<=$szam;$i++){
            echo "<tr>";
            for($j=1;$j<=$szam;$j++){
                if($i==$j){
                    echo "<td style='background-color: blue;'>" . ($i * $j) . "</td>";
                }
                echo "<td>";
                echo $i*$j;
                

            }
            

        }  echo "</td>";
        
        }
        szorzotabla($n);
        
        ?>
</body>
</html>