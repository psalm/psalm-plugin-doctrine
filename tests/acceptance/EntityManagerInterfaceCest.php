<?php namespace Weirdan\DoctrinePsalmPlugin\Tests;
use Weirdan\DoctrinePsalmPlugin\Tests\AcceptanceTester;

class EntityManagerInterfaceCest
{
    private function code(string $code): string
    {
        return '
        <?php
            use Doctrine\ORM\EntityManagerInterface;
            use Doctrine\ORM\EntityRepository;

        ' . $code;
    }

    public function getRepositoryIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            interface I {}
            function f(EntityManagerInterface $em): void {
                atan($em->getRepository(I::class));
            }
        '));
        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' Doctrine\ORM\EntityRepository<I> provided'
        );
    }

    public function findIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            interface I {}
            function f(EntityManagerInterface $em): void {
                atan($em->find(I::class, 1));
            }
        '));
        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' null|I provided'
        );
    }

    public function getReferenceIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            interface I {}
            function f(EntityManagerInterface $em): void {
                atan($em->getReference(I::class, 1));
            }
        '));
        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' I provided'
        );
    }
}
