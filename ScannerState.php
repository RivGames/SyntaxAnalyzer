<?php

class ScannerState
{
    public int $line_no;
    public int $char_no;
    public ?string $token;
    public int $toke_type;
    public Context $context;
    public Reader $r;

}