<?php
require_once "Reader.php";

class StringReader implements Reader
{
    private int $pos;
    private int $len;

    public function __construct(private string $in)
    {
        $this->pos = 0;
        $this->len = strlen($in);
    }

    public function pushBackChar(): void
    {
        $this->pos--;
    }

    public function getPos(): int
    {
        return $this->getPos();
    }

    public function getChar(): string|bool
    {
        if ($this->pos >= $this->len) {
            return false;
        }
        $char = substr($this->in, $this->pos, 1);
        $this->pos++;
        return $char;
    }

    public function string(): string
    {
        return $this->in;
    }

}