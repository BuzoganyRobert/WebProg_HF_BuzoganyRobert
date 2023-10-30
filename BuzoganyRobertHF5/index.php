<?php

require_once "Student.php";
require_once "Subject.php";
require_once "University.php";

//ToDo

$uni=new University();

$matek=null;
$progi=null;
$rajz=null;

try {
    $matek=$uni->addSubject('231',"Matematika");
    $progi=$uni->addSubject('225','Webprogramozas');
    $rajz=$uni->addSubject("201","Rajzolas");

}catch (Exception $e)
{
    echo $e->getMessage();
}
$matek->addStudent("Ferkoka",'1');
$matek->addStudent("Andi",'2');
$matek->addStudent("Lajos",'3');
$andras=new Student("Andras","8");



$progi->addStudent("Joco",'4');
$progi->addStudent("Ancsa",'5');
$progi->addStudent("Akos",'6');
$uni->addStudentOnSubject('231',new Student("Jani",'7'));
$uni->addStudentOnSubject('225',$andras);
$studentMatek=$matek->getStudents();
$studentProgi=$progi->getStudents();

$uni->print();
echo "Total number of students: ".$uni->getNumberOfStudents()."<br>";


echo "Rajz ora törles után és Joco törlés után:"."<br>";
$uni->deleteSubject($rajz);
foreach ($studentProgi as $student){
    if($student->getName()=="Joco"){
        $progi->deleteStundet($student);
}


}



$uni->print();

$uni->deleteSubject($rajz);
echo "<br>";
echo "A progi jegyek 2.1 valo beállitasa Akosnak"."<br>";

foreach ($studentProgi as $student)
{
    if($student->getName()=="Akos"){

        $student->setGrades($progi,4.1);
        $student->print();
    }

    


}
echo "<br>";
echo "A getAvgGrade kiprobálása mindenkihez adunk jegyejet";
foreach ($studentProgi as $student) {
    if ($student->getName() == "Akos") {

        $student->setGrades($progi, 5.0);

    }
}
foreach ($studentProgi as $student) {
    if ($student->getName() == "Akos") {

        $student->setGrades($progi, 4.1);

    }
}
foreach ($studentProgi as $student) {
    if ($student->getName() == "Ancsa") {

        $student->setGrades($progi, 4.1);

    }
}
foreach ($studentProgi as $student) {
    if ($student->getName() == "Ancsa") {

        $student->setGrades($progi, 3.1);

    }
}


foreach ($studentProgi as $student) {
    if ($student->getName() == "Andras") {

        $student->setGrades($progi, 4.1);

    }
}

echo "<br>";
$totalAvg = 0;
$count = 0;

foreach ($studentProgi as $student) {
    $avg = $student->getAVGGrades();
    $totalAvg += $avg;
    $count++;
}

if ($count > 0) {
    $average = $totalAvg / $count;
} else {
    $average = 0.0;
}

echo "Az összes hallgató átlaga: " . $average;
