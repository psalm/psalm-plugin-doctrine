Feature: Expr
  In order to use Doctrine Dbal ExpressionBuilder safely
  As a Psalm user
  I need Psalm to typecheck Expr

  Background:
    Given I have Doctrine plugin enabled
    And I have the following code preamble
      """
      <?php
      use Doctrine\DBAL\Query\QueryBuilder;
      use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
      use Doctrine\DBAL\Query\Expression\CompositeExpression;

      /**
       * @psalm-suppress InvalidReturnType
       * @return QueryBuilder
       */
      function builder() {}
      """
    # Psalm enables cache when there's a composer.lock file
    And I have empty composer.lock

  @ExpressionBuilder
  Scenario: ExpressionBuilder::andX() accepts variadic arguments
    Given I have the "doctrine/dbal" package satisfying the ">= 2.11"
    And I have the following code
      """
      builder()->expr()->andX(
        'foo > bar',
        'foo < baz'
      );
      """
    When I run Psalm
    Then I see these errors
      | DeprecatedMethod | The method Doctrine\DBAL\Query\Expression\ExpressionBuilder::andX has been marked as deprecated |

  @ExpressionBuilder
  Scenario: ExpressionBuilder::andX() accepts variadic arguments
    Given I have the "doctrine/dbal" package satisfying the "< 2.11"
    And I have the following code
      """
      builder()->expr()->andX(
        'foo > bar',
        'foo < baz'
      );
      """
    When I run Psalm
    Then I see no errors

  @ExpressionBuilder
  Scenario: ExpressionBuilder::orX() accepts variadic arguments
    Given I have the "doctrine/dbal" package satisfying the ">= 2.11"
    And I have the following code
      """
      $expr = builder()->expr();
      $expr->orX(
        $expr->eq('foo', 1),
        $expr->eq('bar', 1)
      );
      """
    When I run Psalm
    Then I see these errors
      | DeprecatedMethod | The method Doctrine\DBAL\Query\Expression\ExpressionBuilder::orX has been marked as deprecated |

  @ExpressionBuilder
  Scenario: ExpressionBuilder::orX() accepts variadic arguments
    Given I have the "doctrine/dbal" package satisfying the "< 2.11"
    And I have the following code
      """
      $expr = builder()->expr();
      $expr->orX(
        $expr->eq('foo', 1),
        $expr->eq('bar', 1)
      );
      """
    When I run Psalm
    Then I see no errors

