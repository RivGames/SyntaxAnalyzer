<?php
require_once "Handler.php";
class BooleanAndHandler implements Handler
{
    public function handleMatch(Parser $parser, Scanner $scanner): void
    {
        $comp1 = $scanner->getContext()->popResult();
        $comp2 = $scanner->getContext()->popResult();
        $scanner->getContext()->pushResult(new BooleanAndExpression($comp1,$comp2));
    }
}