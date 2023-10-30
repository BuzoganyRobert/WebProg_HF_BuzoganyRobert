<?php
require_once "AbstractUniversity.php";

class University extends AbstractUniversity
{
    // TODO Implement all the methods declared in parent
    private function isSubjectExists(string $code, string $name): bool
    {
        if (count($this->subjects) == 0) return false;
        foreach ($this->subjects as $subject) {
            if ($subject->getCode() == $code && $subject->getName() == $name) {
                return true;
            }
        }
        return false;
    }
    public function addSubject(string $code, string $name): Subject

        // TODO: Implement addSubject() method.
        {
            if (!$this->isSubjectExists($code, $name)) {
                $subject = new Subject($code, $name);
                $this->subjects[] = $subject;
                return $subject;
            } else {
                throw new Exception("Subject exists!");
            }
        }




    public function addStudentOnSubject(string $subjectCode, Student $student)
    {
        // TODO: Implement addStudentOnSubject() method.
        foreach ($this->subjects as $subject)
        {
            if($subject->getCode()==$subjectCode)
            {

                $subject->addStudent($student->getName(),$student->getStudentNumber());
            }


        }
    }

    public function getStudentsForSubject(string $subjectCode)

    {
        // TODO: Implement getStudentsForSubject() method.

        foreach ($this->subjects as $subject)
        {
            if ($subject->getCode()==$subjectCode)
            {
                return $subject->getStudents();
            }
        }
    return [];
    }

    public function getNumberOfStudents(): int
    {
        // TODO: Implement getNumberOfStudents() method.
        $totalNumberOfStudents=0;
        foreach ($this->subjects as $subject)
        {
            $totalNumberOfStudents+=count($subject->getStudents());
        }
        return $totalNumberOfStudents;
    }

    public function print()
    {
        // TODO: Implement print() method.
        foreach ($this->subjects as $subject){
            echo '----------------------'."<br>";
            echo  $subject."<br>";
            echo '----------------------'."<br>";
            foreach ($subject->getStudents()as $student)
            {
                echo  $student->getName()." - ".$student->getStudentNumber();
                echo "<br>";
            }
        }
    }
    public function deleteSubject(Subject $subject)
    {
        $studentInSubject=$subject->getStudents();
        if(empty($studentInSubject)){
        $index=array_search($subject,$this->subjects,true);
        if($index!==false)
        {
            unset($this->subjects[$index]);
            $this->subjects=array_values($this->subjects);
        }
        }else{
            throw new Exception("A student has this subject, can not be deleted");
        }
    }

}
