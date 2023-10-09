<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
class BevasarloLista{
    private $bevasarloLista;
     

    public function __construct(){
        $this->bevasarloLista=array();
    }
    public function addItems($name,$quantity,$price){
        $newItem=array(
            "nev"=>$name,
            "mennyiseg"=>$quantity,
            "egysegar"=>$price
        );
        $this->bevasarloLista[]=$newItem;
    }
    public function deleteItems($name){
        foreach($this->bevasarloLista as $index=>$item){
            if($item['nev']==$name){
                unset($this->bevasarloLista[$index]);
            }
        }
        $this->bevasarloLista=array_values($this->bevasarloLista);
    }
    public function toString(){
        foreach($this->bevasarloLista as $item){
            echo "Nev: ".$item["nev"].", Mennyiseg: ".$item["mennyiseg"].", Egysegar: ".$item["egysegar"]."<br>";
        }
    }
    public function addPrices(){
        $payment=0;
        foreach($this->bevasarloLista as $item){
            $payment+=$item["mennyiseg"]*$item["egysegar"];
        }
        return $payment;
    }

}

$bevasarlas=new BevasarloLista();
$bevasarlas->addItems("Kenyer",2,8.5);
$bevasarlas->addItems("Viz",3,2.75);

$bevasarlas->toString();
echo "Osszkoltseg: ";
$bevasarlas->addPrices();
echo "<br>";
echo "Kitoroljuk a vizet";
$bevasarlas->deleteItems("Viz");
echo "<br>";
echo "Kiiratas modositas utan:";
$bevasarlas->toString();













    ?>
</body>
</html>