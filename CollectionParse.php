<?php
require_once "Parser.php";

abstract class CollectionParse extends Parser
{
    protected array $parsers = [];

    public function add(Parser $parser): Parser
    {
        if (is_null($parser)) {
            throw new Exception("аргумент равен null");
        }
        $this->parsers[] = $parser;
        return $parser;
    }

    public function term(): bool
    {
        return false;
    }
}