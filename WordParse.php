<?php
require_once "Parser.php";
class WordParse extends Parser
{
    public function __construct(private $word = null,string $name = null, array $options = [])
    {
        parent::__construct($name, $options);
    }

    public function trigger(Scanner $scanner): bool
    {
        if($scanner->tokenType() != Scanner::WORD){
            return false;
        }
        if(is_null($this->word)){
            return true;
        }
        return $this->word == $scanner->token();
    }

    protected function doScan(Scanner $scanner): bool
    {
        return $this->trigger($scanner);
    }
}