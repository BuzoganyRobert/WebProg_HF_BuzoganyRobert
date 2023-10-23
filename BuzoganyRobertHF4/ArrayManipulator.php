<?php

namespace lab4hf;

class ArrayManipulator
{
    private $data = [];

    public function __get($key)
    {
        // TODO: Implement __get() method.
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }

    public function __set($key, $value): void
    {
        // TODO: Implement __set() method.
        $this->data[$key] = $value;
    }

    public function __isset($key): bool
    {
        // TODO: Implement __isset() method.
        return isset($this->data[$key]);
    }

    public function __unset($key): void
    {
        // TODO: Implement __unset() method.
        unset($this->data[$key]);
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return json_encode($this->data);
    }

    public function __clone()
    {
        // TODO: Implement __clone() method.
        $this->data = array_map(function ($item) {
            return is_object($item) ? clone $item : $item;
        }, $this->data);
    }

}

/*Testing*/

$manipulator=new ArrayManipulator();
$manipulator->name="Jani";
$manipulator->age=30;

echo $manipulator->name ;
echo "<br>";
echo  isset($manipulator->age) ? "Age is set":"Age is not set";
echo "<br>";

unset($manipulator->age);
echo  isset($manipulator->age) ? "Age is set":"Age is not set";
echo "<br>";
echo  $manipulator. PHP_EOL;


$cloneOne=clone $manipulator;
$cloneOne->name="Robi";
echo "<br>";
echo $cloneOne->name." - ".$manipulator->name;