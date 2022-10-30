<?php
require_once "Context.php";
require_once "Scanner.php";
require_once "StringReader.php";

$context = new Context();
$user_in = "\$input equals '4' or \$input equals 'four'";
$reader = new StringReader($user_in);
$scanner = new Scanner($reader, $context);
while ($scanner->nextToken() != Scanner::EOF) {
    print($scanner->token());
    print("     {$scanner->charNo()}");
    print("     {$scanner->getTypeString()}\n");
}