Feature: Criteria
  In order to use Doctrine Criteria
  As a Psalm user
  I need Psalm to typecheck Criteria

  Background:
    Given I have Doctrine plugin enabled
    And I have the following code preamble
      """
      <?php
      use Doctrine\Common\Collections\Selectable;
      use Doctrine\Common\Collections\Criteria;
      """
    # Psalm enables cache when there's a composer.lock file
    And I have empty composer.lock
    
    @Criteria::create
    Scenario: Creating a Criteria in a pure context
      Given I have the following code
      """
      /** @psalm-pure */
      function foo(Selectable $collection): Selectable
      {
          return $collection->matching(Criteria::create());
      }
      """
    When I run Psalm
    Then I see no errors
    
    @Criteria::orderBy
    Scenario: Order a Criteria in a pure context
      Given I have the following code
      """
      /** @psalm-pure */
      function foo(Selectable $collection): Selectable
      {
          return $collection->matching(Criteria::create()->orderBy(['foo' => Criteria::ASC]));
      }
      """
    When I run Psalm
    Then I see no errors
    
    @Criteria::orderBy
    Scenario: Invalid sorting provided to matching
      Given I have the following code
      """
      /** @psalm-pure */
      function foo(Selectable $collection): Selectable
      {
          return $collection->matching(Criteria::create()->orderBy(['foo' => 'bar']));
      }
      """
    When I run Psalm
    Then I see these errors
      | Type                  | Message                                                                                   |
      | todo | todo |
    And I see no other errors
