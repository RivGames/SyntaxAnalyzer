<?php

class Scanner
{
    public const WORD = 1;
    public const QUOTE = 2;
    public const APOS = 3;
    public const WHITESPACE = 6;
    public const EOL = 8;
    public const CHAR = 9;
    public const EOF = 0;
    public const SOF = -1;
    protected int $line_no = 1;
    protected int $char_no = 0;
    protected ?string $token = null;
    protected int $token_type = -1;

    public function __construct(private Reader $r, private Context $context)
    {
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    public function eatWhiteSpace(): int
    {
        $ret = 0;
        if ($this->token_type != self::WHITESPACE && $this->token_type != self::EOL) {
            return $ret;
        }
        while ($this->nextToken() == self::WHITESPACE || $this->token_type == self::EOL) {
            $ret++;
        }
    }

    public function getTypeString(int $int = -1): ?string
    {
        if ($int < 0) {
            $int = $this->tokenType();
        }
        if ($int < 0) {
            return null;
        }
        $resolve = [
            self::WORD => 'WORD',
            self::QUOTE => 'QUOTE',
            self::APOS => 'APOS',
            self::WHITESPACE => 'WHITESPACE',
            self::EOL => 'EOL',
            self::CHAR => 'CHAR',
            self::EOF => 'EOF'
        ];
        return $resolve[$int];
    }

    public function tokenType(): int
    {
        return $this->token_type;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function isWord(): bool
    {
        return ($this->token_type == self::WORD);
    }

    public function isQuote(): bool
    {
        return ($this->token_type == self::APOS || $this->token_type == self::QUOTE);
    }

    public function lineNo(): int
    {
        return $this->line_no;
    }

    public function charNo(): int
    {
        return $this->char_no;
    }

    public function __clone(): void
    {
        $this->r = clone($this->r);
    }
    // Переход к следующему токену в исходном файле.
    // Устанавливает текущий токен и отслеживает номер строки
    // и номер символа
    public function nextToken(): int
    {
        $this->token = null;
        $type = -1;
        while (!is_bool($char = $this->getChar())) {
            if ($this->isEolChar($char)) {
                $this->token = $this->manageEolChars($char);
                $this->line_no++;
                $this->char_no++;
                return ($this->token_type = self::EOL);
            } elseif ($this->isWordChar($char)) {
                $this->token = $this->eatWordChars($char);
                $type = self::WORD;
            } elseif ($this->isSpaceChar($char)) {
                $this->token = $char;
                $type = self::WHITESPACE;
            } elseif ($char == "'") {
                $this->token = $char;
                $type = self::APOS;
            } elseif ($char = '"') {
                $this->token = $char;
                $type = self::QUOTE;
            } else {
                $type = self::CHAR;
                $this->token = $char;
            }
            $this->char_no += strlen($this->token());
            return ($this->token_type = $type);
        }
        return ($this->token_type = self::EOF);
    }
    // Возвращает массив, содержащий тип и содержимое
    // следующего токена
    public function peekToken(): array
    {
        $state = $this->getState();
        $type = $this->nextToken();
        $token = $this->token();
        $this->setState($state);
        return [$type, $token];
    }
    // Получает обьект типа ScannerState,содержащий
    // текущую позицию сканера в исходном файле
    // и сведения о текущем токене
    public function getState(): ScannerState
    {
        $state = new ScannerState();
        $state->line_no = $this->line_no;
        $state->char_no = $this->char_no;
        $state->token = $this->token;
        $state->token_type = $this->token_type;
        $state->r = clone($this->r);
        $state->context = clone($this->context);
        return $state;
    }
    // Используя обьект ScannerState для восстановления
    // состояния сканера
    public function setState(ScannerState $state): void
    {
        $this->line_no = $state->line_no;
        $this->char_no = $state->char_no;
        $this->token = $state->token;
        $this->token_type = $state->token_type;
        $this->r = $state->r;
        $this->context = $state->context;
    }
    // Возвращает следующий симовл из исходного файла.
    // Если достигнут конец файла то возвращается
    // логическое значение
    public function getChar()
    {
        
    }

}
