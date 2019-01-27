<?php
namespace Weirdan\DoctrinePsalmPlugin\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    public function runPsalmWith(string $code): void
    {
        $this->getModule('Filesystem')->writeToFile('somefile.php', $code);
        $this->getModule('Cli')->runShellCommand('vendor/bin/psalm --output-format=pylint somefile.php', false);
    }

    public function canSeePsalmFailsWith(string $message): void
    {
        $this->getModule('Cli')->seeResultCodeIs(1);
        $this->getModule('Cli')->seeInShellOutput($message);
    }
}
