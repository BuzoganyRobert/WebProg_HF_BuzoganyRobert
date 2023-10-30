<?php
/**
 * User: TheCodeholic
 * Date: 4/8/2020
 * Time: 10:40 PM
 */

/**
 * Class Student
 */
class Student
{
    private string $name;
    private string $studentNumber;
    private array $grades=[];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getStudentNumber(): string
    {
        return $this->studentNumber;
    }

    public function setStudentNumber(string $studentNumber): void
    {
        $this->studentNumber = $studentNumber;
    }

    // TODO Generate constructor with both arguments.
    // TODO Generate getters and setters for both arguments
    /**
     * @param string $name
     * @param string $studentNumber
     */
    public function __construct(string $name, string $studentNumber)
    {
        $this->name = $name;
        $this->studentNumber = $studentNumber;
    }
    public function setGrades(Subject $subject, float $grade)
    {
        $subjectCode = $subject->getCode();
        if ($grade >= 1.0 && $grade <= 5.0) {
            $this->grades[$subjectCode] = $grade;
        } else {
            throw new Exception("Invalid grade. Grades must be between 1.0 and 5.0.");
        }
    }


        

    public function getAVGGrades():float
    {
        if (empty($this->grades)) {
            return 0.0;
        }

        $totalGrades = array_sum($this->grades);
        $numberOfGrades = count($this->grades);
        return $totalGrades / $numberOfGrades;
    }
    public function print()
    {
        if (count($this->grades) === 0) {
            echo "There are no grades";
        } else {
            foreach ($this->grades as $subjectCode => $grade) {
                echo $subjectCode . " - " . $grade . "\n";
            }
        }

    }
}
