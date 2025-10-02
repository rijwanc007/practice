<?php

#method chaining
class Matrix {

    private $title;
    private $dataSet = [];

    public function __construct(string $title = '') {

        $this->title = $title;
    }
    public function addMatrix(string $data) : object {

        $jsonDecode = json_decode($data,true);

        switch ($jsonDecode['type']) {

            case "memory" :
                $this->getMemory($jsonDecode);
                break;

            case "cpu"    :
                $this->getCpu($jsonDecode);
                break;

            case "disk"   :
                $this->getDisk($jsonDecode);
                break;
        }
        return $this;
    }

    public function getMemory(array $data) : object {

        $this->dataSet['getMemoryUses'][] = [
            'value'  => $data['value'],
            'uses'   => $data['uses']
        ];

        return $this;
    }

    public function getCpu(array $data) : object {

        $this->dataSet['getCpuUses'][] = [
            'value'  => $data['value'],
            'uses'   => $data['uses']
        ];

        return $this;
    }

    public function getDisk(array $data) : object {

        $this->dataSet['getDiskUses'][] = [
            'value'  => $data['value'],
            'uses'   => $data['uses']
        ];

        return $this;
    }

    public function details() : array {

        return [$this->title,$this->dataSet];
    }

}

$obj    = new Matrix('Method Chaining');
$result = $obj->addMatrix('{"type":"memory","value":37,"uses":43}')
    ->addMatrix('{"type":"memory","value":40,"uses":57}')
    ->addMatrix('{"type":"cpu","value":37,"uses":43}')
    ->addMatrix('{"type":"disk","value":37,"uses":43}')
    ->details();

echo '<pre>';
print_r($result);
echo '</pre>';

echo "<br/>";
#method chaining

class Calculation {

    private $count = 0;

    public function addCount() {

        $this->count = $this->count + 1;
        return $this;
    }

    public function getCount() : int {

        return $this->count;
    }
}

$result = (new Calculation())->addCount()->addCount()->getCount();
echo $result;

echo "<pre/>";
#peramid show

$n = 6;
for($i=1;$i<=$n;$i++) {

    echo str_repeat(' ', $n-$i) . str_repeat('#', $i);
    echo "<br>";
}

echo "<br/>";
#plus minus zero count

function arrPlusMinusZeroCount($arrPlusMinusZero) {

    $count = count($arrPlusMinusZero);
    $plus  = 0;
    $minus = 0;
    $zero  = 0;

    for($i = 0; $i < $count ; $i++){

        if($arrPlusMinusZero[$i] > 0) {
            $plus++;
        } else if($arrPlusMinusZero[$i] < 0) {
            $minus++;
        } else {
            $zero++;
        }
    }
    var_dump($plus/$count);
    echo "<br/>";
    var_dump($minus/$count);
    echo "<br/>";
    var_dump($zero/$count);
}

$arrPlusMinusZero = [-4, 3, -9, 0, 4, 1];
arrPlusMinusZeroCount($arrPlusMinusZero);

echo "<br/>";
#diagonal difference
function diagonalDifferenceGet($arrDiagonal) {

    $leftDiagonal  = 0;
    $rightDiagonal = 0;
    $lastIndex     = count($arrDiagonal) - 1;

    for($i = 0 ; $i < count($arrDiagonal) ; $i++) {

        $leftDiagonal  += $arrDiagonal[$i][$i];
        $rightDiagonal += $arrDiagonal[$i][$lastIndex--];
    }

    echo "<pre>";
    print_r(abs($leftDiagonal - $rightDiagonal));
    echo "</pre>";
}

$arrDiagonal = [[11, 2, 4], [4, 5, 6], [10, 8, -12]];
diagonalDifferenceGet($arrDiagonal);

#array list organise

function listOrganise(array $list) : array {

    $arrayUnique		 = array_flip(array_unique($list));
    $arrayDiff  		 = array_flip(array_diff_key($list,array_unique($list)));

    return array_merge_recursive($arrayUnique,$arrayDiff);
}

$list = [
    'first.text'  => 'rijwan',
    'second.text' => 'chowdhury',
    'third.text'  => 'rijwan'
];

echo '--array short--'."\n";
echo "<pre>";
print_r(listOrganise($list));
echo "</pre>";

echo "<br/>";

echo "the call_user_func() function in php is an inbuilt function used"."\n";
echo "to call a user-defined function or a method dynamically.it takes the "."\n";
echo "callable to be executed as its first parameter and any subsequent parameters"."\n";
echo "as arguments to that callable";

function greet($name) {
    echo "Hello, " . $name . "!";
}

call_user_func('greet', 'Alice');

echo "<br/>";
class MyClass {
    public function sayHello($name) {
        echo "Hello from MyClass, " . $name . "!";
    }
}

$obj = new MyClass();
call_user_func([$obj, 'sayHello'], 'Bob');

echo "<br/>";
class AnotherClass {
    public static function farewell($name) {
        echo "Goodbye, " . $name . "!";
    }
}

call_user_func(['AnotherClass', 'farewell'], 'Charlie');

echo "<br/>";

$myClosure = function($message) {
    echo "Closure says: " . $message;
};

call_user_func($myClosure, 'Welcome!');


#username changes request

function possibleChanges(array $usernames) : ? array {

   return array_map("swapUsername",$usernames);
}

function swapUsername(string $username) : string {

    $n = strlen($username);
    for($i = 0 ; $i < $n ; $i++) {

        for($j = $i+1 ; $j < $n ; $j++) {

            if($username[$j] < $username[$i]) return 'YES';
        }
    }
    return 'NO';
}

echo "<pre>";
print_r(possibleChanges([
    'bee',
    'hydra'
]));
echo "</pre>";

echo '<br/>';
echo 'late static binding example';
echo '<br/>';

class Base {

    protected static $name = 'rijwan';

    public function showName() : string {

        return self::$name;
    }
}

class Delivered extends Base {

    protected static $name = 'chowdhury';
}

$obj = new Delivered();
echo $obj->showName();

echo "<br/>";
echo "let see how the late static binding work";
echo '<br/>';

class BaseTwo {

    protected static $name = 'rijwan';

    public function showName() : string {

        return static::$name;
    }
}

class DeliveredTwo extends BaseTwo {

    protected static $name = 'chowdhury';
}

$objTwo = new DeliveredTwo();
echo $objTwo->showName();


//https://github.com/kilian-hu/hackerrank-solutions/tree/master/certificates/problem-solving-basic/nearly-similar-rectangles
