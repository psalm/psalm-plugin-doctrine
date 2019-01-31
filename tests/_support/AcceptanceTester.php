<?php
namespace Weirdan\DoctrinePsalmPlugin\Tests;

use Behat\Gherkin\Node\TableNode;
use Codeception\Exception\TestRuntimeException;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\Assert;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /** @var string */
    private const FILENAME = 'tests/_run/somefile.php';

    /** var array<string,string */
    private const VERSION_OPERATORS = [
        'newer than' => '>',
        'older than' => '<',
    ];

    /** @var string */
    private $preamble = '';

    /**
     * @Given I have the following code :code
     */
    public function iHaveTheFollowingCode(string $code): void
    {
        $this->writeToFile(self::FILENAME, $this->preamble . $code);
    }

    /**
     * @When /I run (?:P|p)salm/
     */
    public function iRunPsalm(): void
    {
        $this->runPsalmOn(self::FILENAME);
    }


    /**
     * @Then I see these errors
     */
    public function iSeeTheseErrors(TableNode $list): void
    {
        foreach (array_values($list->getRows()) as $i => $error) {
            if (0 === $i) {
                continue;
            }
            $this->seeThisError($error[0], $error[1]);
        }
    }

    /**
     * @Then /I see no(:? other)? errors/
     */
    public function iSeeNoErrors(): void
    {
        $this->seeNoErrors();
    }

    /**
     * @Given I have the following code preamble :code
     */
    public function iHaveTheFollowingCodePreamble(string $code): void
    {
        $this->preamble = $code;
    }

    /**
     * @Given /I have Psalm (newer than|older than) "([0-9.]+)" \(because of "([^"]+)"\)/
     */
    public function iHavePsalmOfACertainVersionRangeBecauseOf(string $operator, string $version, string $reason): void
    {
        if (!isset(self::VERSION_OPERATORS[$operator])) {
            throw new TestRuntimeException("Unknown operator: $operator");
        }

        $op = self::VERSION_OPERATORS[$operator];

        if (!$this->seePsalmVersionIs($op, $version)) {
            throw new \Codeception\Exception\Skip("This scenario requires Psalm $op $version because of $reason");
        }
    }

    /**
     * @Given I have some future Psalm that supports this feature :ref
     */
    public function iHaveSomeFuturePsalmThatSupportsThisFeature(string $ref)
    {
        throw new \Codeception\Exception\Skip("Future functionality that Psalm has yet to support: $ref");
    }
}
