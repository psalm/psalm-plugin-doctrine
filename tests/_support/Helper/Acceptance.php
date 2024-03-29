<?php

namespace Weirdan\DoctrinePsalmPlugin\Tests\Helper;

use Codeception\Exception\ModuleRequireException;
use Codeception\Module;
use Codeception\TestInterface;

use function array_map;
use function explode;
use function implode;
use function sprintf;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends Module
{
    /**
     * @var mixed[]
     * @psalm-suppress NonInvariantDocblockPropertyType
     */
    protected $config = ['default_dir' => 'tests/_run/'];

    /** @var list<string> */
    private $suppressedIssueHandlers = [];

    public function _before(TestInterface $test): void
    {
        $this->suppressedIssueHandlers = [
            'UnusedVariable',
            'UnusedFunctionCall',
            'UnusedParam',
        ];
    }

    /**
     * @Given I have issue handler :issueHandlers suppressed
     * @Given I have issue handlers :issueHandlers suppressed
     */
    public function configureIgnoredIssueHandlers(string $issueHandlers): void
    {
        $this->suppressedIssueHandlers = array_map('trim', explode(',', $issueHandlers));
    }

    /**
     * @Given I have Doctrine plugin enabled
     * @Given I have Doctrine plugin enabled with the following config :configuration
     */
    public function configureCommonPsalmconfig(string $configuration = ''): void
    {
        $suppressedIssueHandlers = implode("\n", array_map(static function (string $issueHandler): string {
            return sprintf('<%s errorLevel="info"/>', $issueHandler);
        }, $this->suppressedIssueHandlers));

        $psalmModule = $this->getModule(\Weirdan\Codeception\Psalm\Module::class);

        if (! $psalmModule instanceof \Weirdan\Codeception\Psalm\Module) {
            throw new ModuleRequireException(
                $this,
                sprintf('Needs "%s" module', \Weirdan\Codeception\Psalm\Module::class)
            );
        }

        $psalmModule->haveTheFollowingConfig(<<<XML
<?xml version="1.0"?>
  <psalm errorLevel="1">
    <projectFiles>
      <directory name="."/>
      <ignoreFiles> <directory name="../../vendor"/> </ignoreFiles>
    </projectFiles>
    <plugins>
      <pluginClass class="Weirdan\DoctrinePsalmPlugin\Plugin">
        $configuration
      </pluginClass>
    </plugins>
    <issueHandlers>
      $suppressedIssueHandlers
    </issueHandlers>
  </psalm>
XML
        );
    }
}
