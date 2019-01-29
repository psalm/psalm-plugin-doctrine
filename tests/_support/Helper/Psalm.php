<?php
namespace Weirdan\DoctrinePsalmPlugin\Tests\Helper;

use Codeception\Module;
use Codeception\TestInterface;
use Composer\Semver\Comparator;
use Composer\Semver\VersionParser;
use Muglug\PackageVersions\Versions;
use PHPUnit\Framework\Assert;
use Behat\Gherkin\Node\TableNode;

class Psalm extends Module
{
    /** @var array{type:string,message:string}[] */
    public $errors = [];

    public function _before(TestInterface $test): void
    {
        $this->errors = [];
    }

    public function runPsalmOn(string $filename): void
    {
        $this->getModule('Cli')->runShellCommand('vendor/bin/psalm --output-format=json ' . escapeshellarg($filename), false);
        $this->errors = json_decode($this->getModule('Cli')->output, true) ?? [];
        $this->debug($this->remainingErrors());
    }

    public function seeThisError(string $type, string $message): void
    {
        if (empty($this->errors)) {
            Assert::fail("No errors");
        }

        foreach ($this->errors as $i => $error) {
            if ($error['type'] === $type && preg_match($this->convertToRegexp($message), $error['message'])) {
                unset($this->errors[$i]);
                return;
            }
        }

        Assert::fail("Didn't see [ $type $message ] in: \n" . $this->remainingErrors());
    }

    public function seeNoErrors(): void
    {
        if (!empty($this->errors)) {
            Assert::fail("There were errors: \n" . $this->remainingErrors());
        }
    }

    private function convertToRegexp(string $in): string
    {
        return '@' . str_replace('%', '.*', preg_quote($in, '@')) . '@';
    }

    private function remainingErrors(): string
    {
        return (string) new TableNode(array_map(
            function (array $error): array {
                return [
                    'type' => $error['type'] ?? '',
                    'message' => $error['message'] ?? '',
                ];
            },
            $this->errors
        ));
    }

    public function seePsalmVersionIs(string $operator, string $version): bool
    {
        $currentVersion = Versions::getShortVersion('vimeo/psalm');
        $this->debug(sprintf("Current version: %s", $currentVersion));

        // todo: move to init/construct/before?
        $parser = new VersionParser;

        $currentVersion =  $parser->normalize($currentVersion);
        $version = $parser->normalize($version);

        $result = Comparator::compare($currentVersion, $operator, $version);
        $this->debug("Comparing $currentVersion $operator $version => $result");

        return $result;
    }
}
