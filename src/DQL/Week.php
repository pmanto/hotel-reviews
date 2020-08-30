<?php

namespace App\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class Week extends FunctionNode
{
    public $date;
    public $mode;

    /**
     * { @inherit }
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        $sql = 'WEEK(' . $sqlWalker->walkArithmeticPrimary($this->date);
        if ($this->mode != null) {
            $sql .= ', ' . $sqlWalker->walkLiteral($this->mode);
        }
        $sql .= ')';

        return $sql;
    }

    /**
     * { @inherit }
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->date = $parser->ArithmeticPrimary();
        if (Lexer::T_COMMA === $parser->getLexer()->lookahead['type']) {
            $parser->match(Lexer::T_COMMA);
            $this->mode = $parser->Literal();
        }
        
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
