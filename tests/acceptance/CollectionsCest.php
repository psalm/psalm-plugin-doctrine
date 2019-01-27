<?php
namespace Weirdan\DoctrinePsalmPlugin\Tests;
use Codeception\Scenario;
use Weirdan\DoctrinePsalmPlugin\Tests\AcceptanceTester;

class CollectionsCest
{
    private function code(string $code): string
    {
        return '
        <?php
            use Doctrine\Common\Collections\Collection;
            use Doctrine\Common\Collections\ArrayCollection;

        ' . $code;
    }

    public function addIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->add(1);
        '));
        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::add expects string,'
            . ' int% provided'
        );
    }

    public function containsIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->contains(1);
        '));
        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::contains expects string,'
            . ' int% provided'
        );
    }

    public function removeIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->remove(1));
            $c->remove("string key");
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' null|string provided'
        );

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::remove expects int,'
            . ' string% provided'
        );
    }

    public function removeElementIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->removeElement(1);
        '));
        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::removeElement expects string,'
            . ' int% provided'
        );
    }

    public function containsKeyIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->containsKey("string key");
        '));
        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::containsKey expects int,'
            . ' string% provided'
        );
    }

    public function getIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->get(1));
            $c->get("string key");
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' null|string provided'
        );

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::get expects int,'
            . ' string% provided'
        );
    }

    public function getKeysIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->getKeys());
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' array<%, int> provided'
        );
    }

    public function getValuesIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->getValues());
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' array<%, string> provided'
        );
    }

    public function setFirstArgumentIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->set("string key", 1);
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::set expects int,'
            . ' string% provided'
        );
    }

    public function setSecondArgumentIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->set(1, 1);
        '));

        $I->canSeePsalmFailsWith(
            'Argument 2 of Doctrine\Common\Collections\Collection::set expects string,'
            . ' int% provided'
        );
    }

    public function toArrayIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->toArray());
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' array<int, string> provided'
        );
    }

    public function firstIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->first());
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' false|string provided'
        );
    }

    public function lastIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->last());
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' false|string provided'
        );
    }

    public function keyIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            strlen($c->key());
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of strlen expects string,'
            . ' null|int provided'
        );
    }

    public function currentIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->current());
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' false|string provided'
        );
    }

    public function nextIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->next());
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' false|string provided'
        );
    }

    public function existsClosureArgumentIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->exists(function(int $_p): bool { return (bool) rand(0,1); });
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::exists expects Closure(string):bool,'
            . ' Closure(int):bool provided'
        );
    }

    public function existsClosureReturnTypeIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->exists(function(string $_p): int { return rand(0,1); });
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::exists expects Closure(string):bool,'
            . ' Closure(string):int provided'
        );
    }

    public function filterIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->filter(function(string $_p): bool { return (bool) rand(0,1); }));
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' Doctrine\Common\Collections\Collection<int, string> provided'
        );
    }

    public function filterClosureArgumentIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->filter(function(int $_p): bool { return (bool) rand(0,1); });
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::filter expects Closure(string):bool,'
            . ' Closure(int):bool provided'
        );
    }

    public function filterClosureReturnValueIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->filter(function(string $_p): int { return rand(0,1); });
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::filter expects Closure(string):bool,'
            . ' Closure(string):int provided'
        );
    }

    public function forAllClosureFirstArgumentIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->forAll(function(string $_k, string $_v): bool { return (bool) rand(0,1); });
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::forAll expects Closure(int, string):bool,'
            . ' Closure(string, string):bool provided'
        );
    }

    public function forAllClosureSecondArgumentIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->forAll(function(int $_k, int $_v): bool { return (bool) rand(0,1); });
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::forAll expects Closure(int, string):bool,'
            . ' Closure(int, int):bool provided'
        );
    }

    public function forAllClosureReturnValueIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->forAll(function(int $_k, string $_v): int { return rand(0,1); });
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::forAll expects Closure(int, string):bool,'
            . ' Closure(int, string):int provided'
        );
    }

    public function mapIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->map(function(string $_p): bool { return (bool) rand(0,1); }));
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' Doctrine\Common\Collections\Collection<int, bool> provided'
        );
    }

    public function mapClosureArgumentIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->map(function(int $_v): bool { return (bool) rand(0,1); });
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::map expects Closure(string):mixed,'
            . ' Closure(int):bool provided'
        );
    }

    public function partitionIsTyped(AcceptanceTester $I, Scenario $scenario): void
    {
        $scenario->skip('Psalm bug, see vimeo/psalm#1248');

        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->partition(function(string $_p): bool { return (bool) rand(0,1); }));
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' array{0:Doctrine\Common\Collections\Collection<int, string>, '
            .  '1:Doctrine\Common\Collections\Collection<int, string>} provided'
        );
    }

    public function partitionClosureArgumentIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->partition(function(int $_v): bool { return (bool) rand(0,1); });
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::partition expects Closure(string):bool,'
            . ' Closure(int):bool provided'
        );
    }

    public function partitionClosureReturnValueIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->partition(function(string $_v): int { return rand(0,1); });
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::partition expects Closure(string):bool,'
            . ' Closure(string):int provided'
        );
    }

    public function indexOfArgumentIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->indexOf(1);
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::indexOf expects string,'
            . ' int% provided'
        );
    }

    public function indexOfIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            strlen($c->indexOf("z"));
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of strlen expects string,'
            . ' false|int provided'
        );
    }

    public function sliceFirstParamIsChecked(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            $c->slice("string key", null);
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of Doctrine\Common\Collections\Collection::slice expects int,'
            . ' string% provided'
        );
    }

    public function sliceIsTyped(AcceptanceTester $I): void
    {
        $I->runPsalmWith($this->code('
            /** @var Collection<int,string> */
            $c = new ArrayCollection(["a", "b", "c"]);
            atan($c->slice(1, null));
        '));

        $I->canSeePsalmFailsWith(
            'Argument 1 of atan expects float,'
            . ' array<int, string> provided'
        );
    }
}
