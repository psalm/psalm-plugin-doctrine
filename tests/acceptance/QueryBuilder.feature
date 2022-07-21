Feature: QueryBuilder
  In order to use Doctrine ORM QueryBuilder safely
  As a Psalm user
  I need Psalm to typecheck QueryBuilder

  Background:
    Given I have Doctrine plugin enabled
    And I have the following code preamble
      """
      <?php
      use Doctrine\ORM\QueryBuilder;
      use Doctrine\ORM\Query\Expr;

      /**
       * @psalm-suppress InvalidReturnType
       * @return QueryBuilder
       */
      function builder() {}
      """
    # Psalm enables cache when there's a composer.lock file
    And I have empty composer.lock

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
      $expr = new Expr\Andx(['a = b']);
      builder()->having($expr)->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: Query builder andHaving accepts array expr
    Given I have the following code
      """
      $expr = new Expr\Andx(['a = b']);
      builder()->andHaving([$expr])->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: QueryBuilder::select() rejects wrong stringable arguments
    Given I have the following code
      """
      builder()->select(new Expr\Andx(['a = b']))->distinct();
      """
    When I run Psalm
    Then I see these errors
      | Type                 | Message                                                                                                                                                                                                                    |
      | ImplicitToStringCast | Argument 1 of Doctrine\ORM\QueryBuilder::select expects Doctrine\ORM\Query\Expr\Func\|array<array-key, Doctrine\ORM\Query\Expr\Func\|string>\|null\|string, Doctrine\ORM\Query\Expr\Andx provided with a __toString method |

  @QueryBuilder
  Scenario: QueryBuilder::select() rejects wrong non-stringable arguments
    Given I have the following code
      """
      builder()->select(2.2)->distinct();
      """
    When I run Psalm
    Then I see these errors
      | Type                  | Message                                                                                                                                                                         |
      | InvalidScalarArgument | Argument 1 of Doctrine\ORM\QueryBuilder::select expects Doctrine\ORM\Query\Expr\Func\|array<array-key, Doctrine\ORM\Query\Expr\Func\|string>\|null\|string, float(2.2) provided |

  @QueryBuilder
  Scenario: QueryBuilder ::where(), ::orWhere() and ::andWhere accept Expr\Comparison
    Given I have the following code
      """
      $expr = new Expr\Comparison('id', Expr\Comparison::EQ, 1);
      builder()->where($expr)->andWhere($expr)->orWhere($expr)->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: QueryBuilder ::where(), ::orWhere() and ::andWhere accept array with Expr\Comparison
    Given I have the following code
      """
      $expr = new Expr\Comparison('id', Expr\Comparison::EQ, 1);
      builder()->where([$expr])->andWhere([$expr])->orWhere([$expr])->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: QueryBuilder ::where(), ::orWhere() and ::andWhere accept Expr\Func
    Given I have the following code
      """
      $expr = new Expr\Func('id IN', [1]);
      builder()->where($expr)->andWhere($expr)->orWhere($expr)->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: QueryBuilder ::where(), ::orWhere() and ::andWhere accept array with Expr\Func
    Given I have the following code
      """
      $expr = new Expr\Func('id IN', [1]);
      builder()->where([$expr])->andWhere([$expr])->orWhere([$expr])->distinct();
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilder
  Scenario: QueryBuilder::getQuery() doesn't cause an error
    Given I have the following code
      """
      builder()->getQuery();
      """
    When I run Psalm
    Then I see no errors
