<?php

interface Reader
{
    public function getChar(): string|bool;

    public function getPos(): int;

    public function pushBackChar(): void;
}
