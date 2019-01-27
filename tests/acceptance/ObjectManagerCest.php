<?php
namespace Weirdan\DoctrinePsalmPlugin\Tests;

use Weirdan\DoctrinePsalmPlugin\Tests\AcceptanceTester;

class ObjectManagerCest
{
    private function code(string $code): string
    {
        return '
        <?php
            use Doctrine\Common\Persistence\ObjectManager;

            interface I {}

            /**
             * @return ObjectManager
             * @psalm-suppress InvalidReturnType
             */
            function om() {}
        ' . $code;
    }

    public function getRepositoryIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            atan(om()->getRepository(I::class));
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' Doctrine\Common\Persistence\ObjectRepository<I> provided'
        );
    }

    public function getClassMetadataIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            atan(om()->getClassMetadata(I::class));
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' Doctrine\Common\Persistence\Mapping\ClassMetadata<I> provided'
        );
    }

    public function findIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            atan(om()->find(I::class, 1));
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' null|I provided'
        );
    }
}
