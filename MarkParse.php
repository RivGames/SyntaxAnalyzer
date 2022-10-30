<?php
require_once "StringReader.php";
class MarkParse
{
    private Parser $expression;
    private Parser $operand;
    private Expression $interpreter;
    public function __construct($statement)
    {
        $this->compile($statement);
    }

    public function evaluate($input): mixed
    {
        $iconText = new InterpreterContext();
        $prefab = new VariableExpression('input',$input);
        // Добавление входной переменной в Context
        $prefab->interpret($iconText);
        $this->interpreter->interpret($iconText);
        return $iconText->lookup($this->interpreter);
    }

    public function compile($statementStr): void
    {
        // Построение дерева синтаксического анализа
        $context = new Context();
        $scanner = new Scanner(new StringReader($statementStr),$context);
        $statement = $this->expression();
        $scanResult = $statement->scan($scanner);
        if(!$scanResult || $scanner->tokenType() != Scanner::EOF){
            $msg = " line: {$scanner->lineNo()} ";
            $msg .= " char: {$scanner->charNo()} ";
            $msg .= " token: {$scanner->token()} ";
            throw new Exception($msg);
        }
        $this->interpreter = $scanner->getContext()->popResult();
    }

    public function expression(): Parser
    {
        if(!isset($this->expression)){
            $this->expression = new SequenceParse();
            $this->expression->add($this->operand());
            $bools =new RepetitionParse();
            $whichbool = new AlternationParse();
            $whichbool->add($this->orExpr());
            $whichbool->add($this->andExpr());
            $bools->add($whichbool);
            $this->expression->add($bools);
        }
        return $this->expression;
    }

    public function orExpr(): Parser
    {
        $or = new SequenceParse();
        $or->add(new WordParse('or'))->discard();
        $or->add($this->operand());
        $or->setHandler(new BooleanOrHandler());
        return $or;
    }

    public function andExpr(): Parser
    {
        $and = new SequenceParse();
        $and->add(new WordParse('and'))->discard();
        $and->add($this->operand);
        $and->setHandler(new BooleanAndHandler());
        return $and;
    }

    public function operand(): Parser
    {
        if(!isset($tihs->operand)){
            $this->operand = new SequenceParse();
            $comp = new AlternationParse();
            $exp = new SequenceParse();
            $exp->add(new CharacterParse('('))->discard();
            $exp->add($this->expression());
            $exp->add(new CharacterParse(')'))->discard();
            $comp->add($exp);
            $comp->add(new StringLiteralParse())->setHandler(new StringLiteralHandler());
            $comp->add($this->variable());
            $this->operand->add($comp);
            $this->operand->add(new RepetitionParse())->add($this->eqExpr());
        }
        return $this->operand;
    }

    public function eqExpr(): Parser
    {
        $equals = new SequenceParse();
        $equals->add(new WordParse('equals'))->discard();
        $equals->add($this->operand);
        $equals->setHandler(new EqualsHandler());
        return $equals;
    }

    public function variable(): Parser
    {
        $variable = new SequenceParse();
        $variable->add(new CharacterParse('$'))->discard();
        $variable->add(new WordParse());
        $variable->setHandler(new VariableHandler());
        return $variable;
    }
    // expr = operand { orExpr | andExpr }
}
