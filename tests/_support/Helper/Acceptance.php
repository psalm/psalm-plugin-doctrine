<?php
namespace Weirdan\DoctrinePsalmPlugin\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    private const FILENAME = 'tests/_run/somefile.php';
    public function runPsalmWith(string $code): void
    {
        $this->getModule('Filesystem')->writeToFile(self::FILENAME, $code);
        $this->getModule('Cli')->runShellCommand('vendor/bin/psalm --output-format=pylint ' . self::FILENAME, false);
    }

    public function canSeePsalmFailsWith(string $message): void
    {
        $this->getModule('Cli')->seeResultCodeIs(1);
        $this->getModule('Cli')->seeInShellOutput($message);
    }
}
