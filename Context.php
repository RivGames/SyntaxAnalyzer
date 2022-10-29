<?php

class Context
{
    public array $resultstack = [];

    public function pushResult($mixed): void
    {
        $this->resultstack[] = $mixed;
    }

    public function popResult(): mixed
    {
        return array_pop($this->resultstack);
    }

    public function resultCount(): int
    {
        return count($this->resultstack);
    }

    public function peekResult(): mixed
    {
        if (empty($this->resultstack)) {
            throw new Exception("empty result stack");
        }
        return $this->resultstack[count($this->resultstack) - 1];
    }
}