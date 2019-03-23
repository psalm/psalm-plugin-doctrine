<?php
namespace Weirdan\DoctrinePsalmPlugin\Tests\Helper;

use Codeception\Exception\ModuleRequireException;
use Codeception\Module\Filesystem;
use Weirdan\Codeception\Psalm;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    /** @var ?Filesystem */
    private $fs = null;
    /**
     * @Given I have the following mapping for :class :mapping
     * @return void
     */
    public function iHaveTheFollowingMappingForC(string $class, string $mapping)
    {
        /**
         * @psalm-suppress MixedAssignment
         * @psalm-suppress InvalidArgument
         */
        $defaultFile = $this->getModule('\\' . Psalm\Module::class)->_getConfig('default_file');
        assert(is_string($defaultFile));

        $dir = dirname($defaultFile) . '/mapping';
        @mkdir($dir, 0755, true);

        $filename = $dir . '/' . str_replace('\\', '.', $class) . '.dcm.xml';
        $this->fs()->writeToFile($filename, $mapping);
    }

    private function fs(): Filesystem
    {
        if (null === $this->fs) {
            $fs = $this->getModule('Filesystem');
            if (!$fs instanceof Filesystem) {
                throw new ModuleRequireException($this, 'Needs Filesystem module');
            }
            $this->fs = $fs;
        }
        return $this->fs;
    }
}
