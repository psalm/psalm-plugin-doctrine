<?php
namespace Weirdan\DoctrinePsalmPlugin\Tests;

use Weirdan\DoctrinePsalmPlugin\Tests\AcceptanceTester;

class EntityRepositoryCest
{
    private function code(string $code): string
    {
        return '
        <?php
            use Doctrine\ORM\EntityRepository;

            interface I {}

            /**
             * @template T
             * @template-typeof T $entityClass
             * @psalm-suppress InvalidReturnType
             * @return EntityRepository<T>
             */
            function repo(string $entityClass) {}

        ' . $code;
    }

    public function findAllIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            atan(repo(I::class)->findAll());
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' array<%, I> provided'
        );
    }

    public function findByIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            atan(repo(I::class)->findBy([]));
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' array<%, I> provided'
        );
    }

    public function findOneByIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            atan(repo(I::class)->findOneBy([]));
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' null|I provided'
        );
    }
}
