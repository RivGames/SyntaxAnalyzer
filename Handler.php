<?php

interface Handler
{
    public function handleMatch(Parser $parser, Scanner $scanner):void;
}