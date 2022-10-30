<?php
require_once "CollectionParse.php";
// В этом анализаторе достигается совпадение
// если оно происходит в одном или двух других
//  подчиненных анализаторах
class AlternationParse extends CollectionParse
{
    public function trigger(Scanner $scanner): bool
    {
        foreach ($this->parsers as $parser) {
            if($parser->trigger($scanner)){
                return true;
            }
        }
        return false;
    }

    protected function doScan(Scanner $scanner): bool
    {
        $type = $scanner->tokenType();
        $start_state = $scanner->getState();
        foreach ($this->parsers as $parser) {
            if($type == $parser->trigger($scanner) && $parser->scan($scanner)){
                return true;
            }
        }
        $scanner->setState($start_state);
        return false;
    }

}