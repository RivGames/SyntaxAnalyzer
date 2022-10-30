<?php
require_once "Handler.php";
class StringLiteralHandler implements Handler
{
    public function handleMatch(Parser $parser, Scanner $scanner): void
    {
        $value = $scanner->getContext()->popResult();
        $scanner->getContext()->pushResult(new LiteralExpression($value));
    }
}