<?php namespace Weirdan\DoctrinePsalmPlugin\Tests;
use Weirdan\DoctrinePsalmPlugin\Tests\AcceptanceTester;

class PaginatorCest
{
    private function code(string $code): string
    {
        return '
        <?php
            use Doctrine\ORM\Tools\Pagination\Paginator;

            interface I {}

            /**
             * @template T
             * @template-typeof T $type
             * @param class-string $type
             * @return Paginator<T>
             * @psalm-suppress InvalidReturnType
             */
            function paginate(string $type) {}

        ' . $code;
    }

    public function paginatorIsIterable(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            foreach (paginate(I::class) as $v) {
                atan($v);
            }
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' I provided'
        );
    }
}
