<?php
require_once "Handler.php";
class EqualsHandler implements Handler
{
    public function handleMatch(Parser $parser, Scanner $scanner): void
    {
        $comp1 = $scanner->getContext()->popResult();
        $comp2 = $scanner->getContext()->popResult();
        $scanner->getContext()->pushResult(new BooleanEqualsExpression($comp1,$comp2));
    }

}