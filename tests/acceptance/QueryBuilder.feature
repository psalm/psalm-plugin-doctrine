Feature: Paginator
  In order to paginate Doctrine Queries safely
  As a Psalm user
  I need Psalm to typecheck Paginator

  Background:
    Given I have the following config
      """
      <?xml version="1.0"?>
      <psalm totallyTyped="true">
        <projectFiles>
          <directory name="."/>
        </projectFiles>
        <plugins>
          <pluginClass class="Weirdan\DoctrinePsalmPlugin\Plugin" />
        </plugins>
      </psalm>
      """
    And I have the following code preamble
      """
      <?php
      use Doctrine\ORM\QueryBuilder;

      /**
       * @psalm-suppress InvalidReturnType
       * @return QueryBuilder
       */
      function builder() {}
      """

  @QueryBuilder
  Scenario: Query builder select accepts variadic arguments
    Given I have the following code
      """
      builder()->select('field1', 'field2')->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: Query builder select accepts array argument
    Given I have the following code
      """
      builder()->select(['field1', 'field1'])->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: Query builder addSelect accepts variadic arguments
    Given I have the following code
      """
      builder()->addSelect('field1', 'field2')->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: Query builder where accepts variadic arguments
    Given I have the following code
      """
      builder()->where('field1', 'field2')->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: Query builder where accepts array argument
    Given I have the following code
      """
      builder()->where(['field1', 'field1'])->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: Query builder having accepts expr
    Given I have the following code
      """
      $expr = new Doctrine\ORM\Query\Expr\Andx('a = b');
      builder()->having($expr)->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: Query builder andHaving accepts array expr
    Given I have the following code
      """
      $expr = new Doctrine\ORM\Query\Expr\Andx('a = b');
      builder()->having([$expr])->distinct();
      """
    When I run Psalm
    Then I see no errors
