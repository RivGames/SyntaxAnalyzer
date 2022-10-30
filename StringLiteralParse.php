<?php
require_once "Parser.php";
// В этом терминальном анализаторе проверяется
// совпадение со строковым литералом
class StringLiteralParse extends Parser
{
    public function trigger(Scanner $scanner): bool
    {
        return (
            $scanner->tokenType() == Scanner::APOS || $scanner->tokenType() == Scanner::QUOTE
        );
    }

    protected function push(Scanner $scanner): void
    {

    }

    protected function doScan(Scanner $scanner): bool
    {
        $quoteChar = $scanner->tokenType();
        $ret = false;
        $string = "";
        while ($token == $scanner->nextToken()) {
            if ($token == $quoteChar) {
                $ret = true;
                break;
            }
            $string .= $scanner->token();
        }
        if ($string && !$this->discard) {
            $scanner->getContext()->pushResult($string);
        }
        return $ret;
    }
}