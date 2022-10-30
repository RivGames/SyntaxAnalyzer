<?php
require_once "Parser.php";

class CharacterParse extends Parser
{
    public function __construct(private string $char, string $name = null, array $options = [])
    {
        parent::__construct($name, $options);
    }

    public function trigger(Scanner $scanner): bool
    {
        return $scanner->token() == $this->char;
    }

    protected function doScan(Scanner $scanner): bool
    {
        return $this->trigger($scanner);
    }

}