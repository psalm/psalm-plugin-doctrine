Feature: ExpressionBuilderCollection
  In order to use Doctrine Collection ExpressionBuilder safely
  As a Psalm user
  I need Psalm to typecheck ExpressionBuilder

  Background:
    Given I have Doctrine plugin enabled
    And I have the following code preamble
      """
      <?php
      use Doctrine\Common\Collections\Criteria;
      use Doctrine\Common\Collections\ExpressionBuilder;
      use Doctrine\Common\Collections\Expr\CompositeExpression;

      """
    # Psalm enables cache when there's a composer.lock file
    And I have empty composer.lock

  @ExpressionBuilderCollection
  Scenario: ExpressionBuilder::andX() accepts variadic arguments
    Given I have the following code
      """
      $expr = Criteria::expr();
      $expr->andX(
        $expr->gt('foo', 1),
        $expr->gt('bar', 1)
      );
      """
    When I run Psalm
    Then I see no errors

  @ExpressionBuilderCollection
  Scenario: ExpressionBuilder::orX() accepts variadic arguments
    Given I have the following code
      """
      $expr = Criteria::expr();
      $expr->orX(
        $expr->eq('foo', 1),
        $expr->eq('bar', 1)
      );
      """
    When I run Psalm
    Then I see no errors

