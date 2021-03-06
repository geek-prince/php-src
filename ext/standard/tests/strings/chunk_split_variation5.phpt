--TEST--
Test chunk_split() function : usage variations - different integer values for 'chunklen' argument(Bug#42796)
--SKIPIF--
<?php
if (PHP_INT_SIZE != 8) die("skip this test is for 64bit platform only");
?>
--FILE--
<?php
/* Prototype  : string chunk_split(string $str [, int $chunklen [, string $ending]])
 * Description: Returns split line
 * Source code: ext/standard/string.c
 * Alias to functions: none
*/

/*
* passsing different integer values for 'chunklen' argument to chunk_split()
* 'ending' is set to '||'
*/

echo "*** Testing chunk_split() : different integer values for 'chunklen' ***\n";

 //Initializing variables
$ending = "||";
$str = "This contains\tand special char & numbers 123.\nIt also checks for \0 char";

// different values for chunklen
$values = array (
  0,  
  1,  
  -123,  //negative integer
  0234,  //octal number
  0x1A,  //hexadecimal number
  PHP_INT_MAX,  //max positive integer number
  PHP_INT_MAX * 3,  //integer overflow
  -PHP_INT_MAX - 1,  //min negative integer

);

for($count = 0; $count < count($values); $count++) {
  echo "-- Iteration $count --\n";
  var_dump( chunk_split($str, $values[$count], $ending) );
}

echo "Done"
?>
--EXPECTF--
*** Testing chunk_split() : different integer values for 'chunklen' ***
-- Iteration 0 --

Warning: chunk_split(): Chunk length should be greater than zero in %s on line %d
bool(false)
-- Iteration 1 --
string(213) "T||h||i||s|| ||c||o||n||t||a||i||n||s||	||a||n||d|| ||s||p||e||c||i||a||l|| ||c||h||a||r|| ||&|| ||n||u||m||b||e||r||s|| ||1||2||3||.||
||I||t|| ||a||l||s||o|| ||c||h||e||c||k||s|| ||f||o||r|| || || ||c||h||a||r||"
-- Iteration 2 --

Warning: chunk_split(): Chunk length should be greater than zero in %s on line %d
bool(false)
-- Iteration 3 --
string(73) "This contains	and special char & numbers 123.
It also checks for   char||"
-- Iteration 4 --
string(77) "This contains	and special ||char & numbers 123.
It als||o checks for   char||"
-- Iteration 5 --
string(73) "This contains	and special char & numbers 123.
It also checks for   char||"
-- Iteration 6 --

Warning: chunk_split() expects parameter 2 to be int, float given in %s on line %d
NULL
-- Iteration 7 --

Warning: chunk_split(): Chunk length should be greater than zero in %s on line %d
bool(false)
Done
