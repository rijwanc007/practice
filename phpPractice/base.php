<?php

echo "array slice example";
echo "<br/>";
echo "the array_slice() function returns selected parts of an array";
echo "<br/>";
echo "syntax : array_slice(array,start,length,preserve)";
echo "<br/>";
$arraySlice = [2, 8, 3, 1, 6];
echo "<pre>";
print_r(array_slice($arraySlice,0,3));
echo "</pre>";

echo "<br/>";

echo "array splice example";
echo "<br/>";
echo "the array_splice() function removes selected elements from an array and replaces it with new elements.";
echo "<br/>";
echo "the function also returns an array with the removed elements";
echo "<br/>";
echo "syntax : array_splice(array,start,length,array)";
echo "<br/>";
$arraySplice = [2, 8, 3, 1, 6];
echo "<pre>";
print_r(array_splice($arraySplice,0,3));
print_r($arraySplice);
echo "</pre>";

echo "<br/>";

echo "array map example";
echo "<br/>";
echo "the array_map() function sends each value of an array to a user-made function,";
echo "<br/>";
echo "and returns an array with new values,";
echo "<br/>";
echo "given by the user-made function.array map is a high order function";
echo "<br/>";
echo "syntax : array_map(myFunction,array1,array2,..)";
echo "<br/>";
function arrayMap($value) {

    return $value * $value;
}
$arrayMap = [1, 2, 3, 4, 5, 6];
echo "<pre>";
print_r(array_map('arrayMap',$arrayMap));
echo "</pre>";

echo "<br/>";

echo "array pop example";
echo "<br/>";
echo "the array_pop() function deletes the last elements of an array";
echo "<br/>";
echo "syntax : array_pop(array)";
echo "<br/>";
$arrayPop = ['rajiv', 'rana', 'robin', 'rijwan'];
echo "<pre>";
array_pop($arrayPop);
print_r($arrayPop);
echo "</pre>";

echo "<br/>";

echo "array pad example";
echo "<br/>";
echo "the array_pad() function inserts a specified number of elements,with a specified value,to an array.";
echo "<br/>";
echo "tip : if you assign a negative size parameter, the function will insert new elements before the original elements.";
echo "<br/>";
echo "note : this function will not delete any elements if the size parameter is less than the size of the original array.";
echo "<br/>";
echo "syntax : array_pad(array,size,value)";
echo "<br/>";
$arrayPad = ['rajiv',"rana","robin","rijwan"];
echo "<pre>";
print_r(array_pad($arrayPad,5,"ridhan"));
echo "</pre>";

echo "<br/>";

echo "array push example";
echo "<br/>";
echo "the array_push() function inserts one or more elements to the end of an array.";
echo "<br/>";
echo "tip : you can add one value , or as many as you like.";
echo "<br/>";
echo "note : even if your array has string keys,your added elements will always have numeric keys.";
echo "<br/>";
echo "syntax : array_push(array,value1,value2,..)";
echo "<br/>";
$arrayPush = ['rajiv', 'rana'];
array_push($arrayPush, 'robin', 'rijwan');
echo "<pre>";
print_r($arrayPush);
echo "</pre>";

echo "<br/>";

$arrayPointer = ["rajiv","rana","robin","rijwan"];
echo "array current example";
echo "<br/>";
echo "the current() function returns the value of the current element in an array";
echo "<br/>";
echo "every array has an internal pointer to its current element, which is initialized to the first element inserted into the array.";
echo "<br/>";
echo "tip : this function does not move the arrays internal pointer.";
echo "<br/>";
echo "syntax : curren(array)";
echo "<br/>";
echo "<pre>";
print_r(current($arrayPointer));
echo "</pre>";

echo "<br/>";

echo "array next example";
echo "<br/>";
echo "the next() function moves the internal pointer to,and outputs,the next element in the array.";
echo "<br/>";
echo "syntax : next(array)";
echo "<br/>";
echo "<pre>";
print_r(next($arrayPointer));
echo "</pre>";

echo "<br/>";

echo "array prev example";
echo "<br/>";
echo "the prev() function moves the internal pointer to, and outputs, the previous element in the array.";
echo "<br/>";
echo "syntax : prev(array)";
echo "<br/>";
echo "<pre>";
print_r(prev($arrayPointer));
echo "</pre>";

echo "<br/>";

echo "array end example";
echo "<br/>";
echo "the end() function moves the internal pointer to, and outputs, the last element in the array";
echo "<br/>";
echo "syntax : end(array)";
echo "<br/>";
echo "<pre>";
print_r(end($arrayPointer));
echo "</pre>";

echo "<br/>";

echo "array reset example";
echo "<br/>";
echo "the reset() function moves the internal pointer ot the first element of the array";
echo "<br/>";
echo "syntax : reset(array)";
echo "<br/>";
echo "<pre>";
print_r(reset($arrayPointer));
echo "</pre>";

echo "<br/>";

echo "sort example";
echo "<br/>";
echo "the sort() function sorts an indexed array in ascending order";
echo "<br/>";
echo "syntax : sort(array, sorttype)";
echo "<br/>";
$sort = [1,9,3,4,6,5,7,8];
sort($sort);
echo "<pre>";
print_r($sort);
echo '</pre>';

echo "<br/>";

echo "rsort example";
echo "<br/>";
echo "the rsort() function sorts an indexed array in descending order.";
echo "<br/>";
echo "syntax : rsort(array, sorttype)";
echo "<br/>";
$rSort = [1,9,3,4,6,5,7,8];
rsort($rSort);
echo "<pre>";
print_r($rSort);
echo "</pre>";

echo "<br/>";

echo "asort example";
echo "<br/>";
echo "the asort() function sorts an associative array in ascending order, according to the value.";
echo "<br/>";
echo "syntax : asort(array, sorttype)";
echo "<br/>";
$aSort = ['rijwan' => 4, 'robin' => 3, 'rajiv' => 1, 'rana' => 2];
asort($aSort);
echo "<pre>";
print_r($aSort);
echo "</pre>";

echo "<br/>";

echo "arsort example";
echo "<br/>";
echo "the arsort() function sorts an associative array in descending order,according to the value";
echo "<br/>";
echo "syntax : arsort(array, sorttype)";
echo "<br/>";
$arSort = ['rijwan' => 4, 'robin' => 3, 'rajiv' => 1, 'rana' => 2];
arsort($arSort);
echo "<pre>";
print_r($arSort);
echo "</pre>";

echo "<br/>";

echo "ksort example";
echo "<br/>";
echo "the ksort() function sorts an associative array in ascending order , according to the key";
echo "<br/>";
echo "syntax : ksort(array, sorttype)";
echo "<br/>";
$kSort = [4 => 'rijwan', 2 => 'rana', 1 => 'rajiv', 3 => 'robin'];
ksort($kSort);
echo "<pre>";
print_r($kSort);
echo "</pre>";

echo "<br/>";

echo "krsort example";
echo "<br/>";
echo "the krsort() function sorts an associative array in descending order , according to the key";
echo "<br/>";
echo "syntax : krsort(array, sorttype)";
echo "<br/>";
$krSort = [4 => 'rijwan', 2 => 'rana', 1 => 'rajiv', 3 => 'robin'];
krsort($krSort);
echo "<pre>";
print_r($krSort);
echo "</pre>";

echo "<br/>";

echo "array search example";
echo "<br/>";
echo "the array_search() function search an array for a value and returns the key";
echo "<br/>";
echo "syntax : array_search(value, array, strict)";
echo "<br/>";
$arraySearch = ['rajiv' => 'raj', 'rana' => 'ran', 'robin' => 'rob', 'rijwan' => 'rij'];
echo "<pre>";
print_r(array_search("rij",$arraySearch));
echo "</pre>";

echo "<br/>";

echo "array merge example";
echo "<br/>";
echo "the array_merge() function mergers one or more arrays into one array";
echo "<br/>";
echo "tip : you can assign one array to the function, or as many as you like.";
echo "<br/>";
echo "note : if you assign only one array to the array_merge() function, and the keys are integers, the function returns a new array with integer keys";
echo "<br/>";
echo "starting at 0 and increases by 1 for each value";
echo "<br/>";
echo "tip : the difference between this function and the array_merge_recursive().function is when two or more array elements have the same key.";
echo "<br/>";
echo "instead of override the keys, the array_merge_recursive() function makes the value as an array.";
echo "<br/>";
$arrayMergeOne = ['rajiv' => 'raj', 'rana' => 'ran'];
$arrayMergeTwo = ['robin' => 'rob', 'rijwan' => 'rij'];
echo "<pre>";
print_r(array_merge($arrayMergeOne,$arrayMergeTwo));
echo "</pre>";

echo "<br/>";

echo "array merge recursive example";
echo "<br/>";
echo "the array_merge_recursive() function merges one or more arrays into one array";
echo "<br/>";
echo "the difference between this function and the array_merge().function is when two or more array elements have the same key.";
echo "<br/>";
echo "instead of override the keys,the array_merge_recursive() function makes the value as an array";
echo "<br/>";
echo "note : if you assign only one array to the array_merge_recursive() function,";
echo "<br/>";
echo "it will behave exactly the same as the array_merge() function";
echo "<br/>";
$arrayMergeRecursiveOne = ['rajiv' => 'manager', 'rana' => 'system engineer', 'robin' => 'system engineer', 'rijwan' => 'genuity systems'];
$arrayMergeRecursiveTwo = ['rijwan' => 'software engineer'];
echo "<pre>";
print_r(array_merge_recursive($arrayMergeRecursiveOne,$arrayMergeRecursiveTwo));
echo "</pre>";

echo "<br/>";

echo "array filter example";
echo "<br/>";
echo "the array_filter() function filters the values of an array using a callback function";
echo "<br/>";
echo "this function passes each value of the input array to the callback function.";
echo "<br/>";
echo "if the callback function returns true,";
echo '<br/>';
echo "the current value from input is returned into the result arrays.array key are preserved";
echo "<br/>";
function arrayFilter($value) {

    return ($value & 1);
}
$arrayFilter = [1, 3, 2, 3, 4];
echo "<pre>";
print_r(array_filter($arrayFilter,"arrayFilter"));
echo "</pre>";

echo "<br/>";

echo "array key exists example";
echo "<br/>";
echo "the array_key_exits() function checks an array for a specified key,and returns true if the key exists and false if the key does not exists.";
echo "<br/>";
echo "tip : remember that if you skip the key when you specify an array,";
echo "<br/>";
echo "an integer key is generated , starting at 0 and increases by 1 fo each value.";
echo "<br/>";
$arrayKeyExists = ['rajiv' => 'raj', 'rana' => 'ran', 'robin' => 'rob', 'rij' => 'rijwan'];
if (array_key_exists("rij", $arrayKeyExists)) echo "key exists";

echo "<br/>";

echo "array flip example";
echo "<br/>";
echo "the array_flip() function flips/exchanges all keys with their associated values in an array";
echo "<br/>";
$arrayFlip = [1 => 'rajiv', 2 => 'rana', 3 => 'robin', 4 => 'rijwan'];
echo "<pre>";
print_r(array_flip($arrayFlip));
echo "</pre>";

echo "<br/>";

echo "array fill keys example";
echo "<br/>";
echo "the array_fill_keys() function fills an array with values,specifying keys";
echo "<br/>";
$arrayFillKeys = [1, 2, 3, 4, 5, 6];
echo "<pre>";
print_r(array_fill_keys($arrayFillKeys,'rijwan'));
echo '</pre>';

echo "<br/>";

echo "array fill example";
echo "<br/>";
echo "the array_fill() function fills an array with values";
echo "<br/>";
echo "<pre>";
print_r(array_fill(3,4,'rijwan'));
echo "</pre>";

echo "<br/>";

echo "array keys example";
echo "<br/>";
echo "the array_keys() function returns an array containing the keys";
echo "<br/>";
$arrayKeys = ['rajiv' => 'raj', 'rana' => 'ran', 'robin' => 'rob', 'rijwan' => 'rij'];
echo "<pre>";
print_r(array_keys($arrayKeys));
echo "</pre>";

echo "<br/>";

echo "array values example";
echo "<br/>";
echo "the array_values() function returns an array containing all the values of an array";
echo "<br/>";
echo "tip : the returned array will have numeric keys,starting at 0 and increase by 1";
echo "<br/>";
$arrayValues = ['rajiv' => 'raj', 'rana' => 'ran', 'robin' => 'rob', 'rijwan' => 'rij'];
echo "<pre>";
print_r(array_values($arrayValues));
echo "</pre>";

echo "<br/>";

echo "array column example";
echo "<br/>";
echo "the array_column() function returns the values from a single column in the input array";
echo "<br/>";
$arrayColumn = [
    ['first_name' => 'rajiv', 'last_name' => 'chowdhury'],
    ['first_name' => 'rana', 'last_name' => 'chowdhury'],
    ['first_name' => 'robin', 'last_name' => 'chowdhury'],
    ['first_name' => 'rijwan', 'last_name' => 'chowdhury']
];
echo "<pre>";
print_r(array_column($arrayColumn,'first_name'));
echo "</pre>";

echo "<br/>";

echo "array change key case example";
echo "<br/>";
echo "the array_change_key_case() function changes all keys in an array to lowercase or uppercase";
echo "<br/>";
$arrayChangeKeyCase = ['rijwan' => 1, 'chowdhury' => 2, 'supol' => 3];
echo "<pre>";
print_r(array_change_key_case($arrayChangeKeyCase,CASE_UPPER));
echo "</pre>";

echo "<br/>";

echo "array reverse example";
echo "<br/>";
echo "the array_reverse() function returns an array in the reverse order";
echo "<br/>";
$arrayReverse = [1,2,5,4,7,8,5,3];
echo "<pre>";
print_r(array_reverse($arrayReverse));
echo "</pre>";

echo "<br/>";

echo "array sum example";
echo "<br/>";
echo "the array_sum() function returns the sum of all the values in the array";
echo "<br/>";
$arraySum = [1, 2, 3, 4, 5, 6, 7, 8, 9];
echo "<pre>";
print_r(array_sum($arraySum));
echo "</pre>";

echo "<br/>";

echo "array shift example";
echo "<br/>";
echo "the array_shift() function removes the first element from an array,";
echo "<br/>";
echo "and returns the value of the removed element.";
echo "<br/>";
echo "note : if the keys are numeric,all elements will get new keys,starting from 0 and increases by 1";
echo "<br/>";
$arrayShift = ['rajiv' => 'manager', 'rana' => 'system engineer', 'robin' => 'system engineer', 'rijwan' => 'software engineer'];;
echo "<pre>";
print_r(array_shift($arrayShift));
echo "<br/>";
print_r($arrayShift);
echo "</pre>";

echo "<br/>";

echo "array count values example";
echo "<br/>";
echo "the array_count_values() function counts all the values of an array";
echo "<br/>";
$arrayCountValues = ['rijwan', 'chowdhury', 'rijwan', 'supol'];
echo "<pre>";
print_r(array_count_values($arrayCountValues));
echo "</pre>";

echo "<br/>";

echo "array chunk example";
echo "<br/>";
echo "the array_chunk() function splits an array into chunks of new arrays.";
echo "<br/>";
$arrayChunk = ["Volvo","BMW","Toyota","Honda","Mercedes","Opel"];
echo "<pre>";
print_r(array_chunk($arrayChunk,2));
echo "</pre>";

echo "<br/>";

echo "array combine example";
echo "<br/>";
echo "the array_combine() function creates an array by using the elements from one keys array and one values array";
echo "<br/>";
echo "note : both array must have equal number of elements";
echo "<br/>";
$firstName = ['rajiv','rana','robin','rijwan'];
$age       = [42,38,35,31];
echo "<pre>";
print_r(array_combine($firstName,$age));
echo "<pre/>";

echo "<br/>";

echo "array diff example";
echo "<br/>";
echo "the array_diff() function compares the values of two (or more) arrays, and returns the differences.";
echo "<br/>";
echo "this function compares the values of two(or more) arrays,and returns an array that contains the entries";
echo "<br/>";
echo "from array1 that are not present in array2 or array3, etc";
echo "<br/>";
$arrayDiffOne = ['rajiv' => "raj", 'rana' => "ran", 'robin' => "rob", 'rijwan' => "rij"];
$arrayDiffTwo = ['rajiv' => "raj", 'rana' => "ran", 'robin' => "rob"];
echo "<pre>";
print_r(array_diff($arrayDiffOne,$arrayDiffTwo));
echo "</pre>";

echo "<br/>";




function arrayWalkRecursive($value, $key)
{

    echo "the key $key has the value $value";
    echo "\n";
}

$arrayWalkRecursiveOne = ['rajiv' => 'raj', 'rana' => 'ran'];
$arrayWalkRecursiveTwo = [$arrayWalkRecursiveOne, 'robin' => 'rob', 'rijwan' => 'rij'];
echo '--array walk recursive--';
array_walk_recursive($arrayWalkRecursiveTwo, "arrayWalkRecursive");
echo "\n";

function arrayWalk($value, $key)
{

    echo "the key $key has the value $value";
    echo "\n";
}

$arrayWalk = ['rajiv' => 'raj', 'rana' => 'ran', 'robin' => 'rob', 'rij' => 'rijwan'];
echo '--array walk--' . "\n";
array_walk($arrayWalk, "arrayWalk");
echo "\n";

$arrayDiffKeyOne = ['rajiv' => 'raj', 'rana' => 'ran', 'robin' => 'rob', 'rij' => 'rijwan'];
$arrayDiffKeyTwo = ['rajiv' => 'raj', 'rana' => 'ran', 'robin' => 'rob', 'rijwan' => 'rij'];
echo '--array diff key--' . "\n";
var_dump(array_diff_key($arrayDiffKeyOne, $arrayDiffKeyTwo));
echo "\n";

$arrayDiffAssocOne = ['rajiv' => "raj", 'rana' => "ran", 'robin' => "robin", 'rijwan' => "rij"];
$arrayDiffAssocTwo = ['rajiv' => "raj", 'rana' => "ran", 'robin' => "rob"];
echo '--array diff assoc--' . "\n";
var_dump(array_diff_assoc($arrayDiffAssocOne, $arrayDiffAssocTwo));
echo "\n";










$max = [2, 3, 4, 5, 6, 7, 8, 9];
echo '---array max value---' . "\n";
echo max($max);
echo "\n";

$min = [2, 3, 4, 5, 6, 7, 8, 9];
echo '---array min value---' . "\n";
echo min($min);

$inArray = ['rijwan', 'chowdhury', 'younusur'];
echo '--in array check--' . "\n";
if (in_array('rijwan', $inArray)) {

    echo "have";
} else {

    echo "not found";
}

