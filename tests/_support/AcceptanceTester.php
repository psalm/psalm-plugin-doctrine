<?php

namespace Weirdan\DoctrinePsalmPlugin\Tests;

use Codeception\Actor;

class AcceptanceTester extends Actor
{
    use _generated\AcceptanceTesterActions;
    /**
     * @Given I have empty composer.lock
     */
    public function iHaveEmptyComposerlock()
    {
        $this->writeToFile('tests/_run/composer.lock', '{}');
    }
}
