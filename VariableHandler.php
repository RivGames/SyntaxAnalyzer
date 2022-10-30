<?php
require_once "Handler.php";
class VariableHandler implements Handler
{
    public function handleMatch(Parser $parser, Scanner $scanner): void
    {
        $varName = $scanner->getContext()->popResult();
        $scanner->getContext()->pushResult(new VariableExpression($varName));
    }

}