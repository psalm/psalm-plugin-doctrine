<?php

namespace Doctrine\ORM\Query;

class Expr
{
    /**
     * @param Expr\Comparison|Expr\Func|Expr\Andx|Expr\Orx|string ...$x
     */
    public function andX(...$x): Expr\Andx
    {
    }

    /**
     * @param Expr\Comparison|Expr\Func|Expr\Andx|Expr\Orx|string ...$x
     */
    public function orX(...$x): Expr\Orx
    {
    }
}
