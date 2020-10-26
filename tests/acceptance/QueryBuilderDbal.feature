Feature: QueryBuilderDbal
  In order to use Doctrine DBAL QueryBuilder safely
  As a Psalm user
  I need Psalm to typecheck QueryBuilder

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
      use Doctrine\DBAL\Query\QueryBuilder;
      use Doctrine\DBAL\Query\Expression\CompositeExpression;

      /**
       * @psalm-suppress InvalidReturnType
       * @return QueryBuilder
       */
      function builder() {}
      """

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::select accepts variadic arguments
    Given I have the following code
      """
      builder()->select('field1', 'field2');
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::select accepts array argument
    Given I have the following code
      """
      builder()->select(['field1', 'field1']);
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::addSelect accepts variadic arguments
    Given I have the following code
      """
      builder()->addSelect('field1', 'field2');
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::addSelect accepts array argument
    Given I have the following code
      """
      builder()->addSelect(['field1', 'field2']);
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::where, ::orWhere and ::andWhere accept variadic arguments
    Given I have the following code
      """
      builder()->where('field1', 'field2')
               ->andWhere('field1', 'field2')
               ->orWhere('field1', 'field2');
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::where, ::orWhere and ::andWhere accept CompositeExpression
    Given I have the "doctrine/dbal" package satisfying the ">= 2.11.0"
    And I have the following code
      """
      $expr = builder()->expr();
      $orx = $expr->orX();
      $orx->add($expr->eq('field1', 1));
      $orx->add($expr->eq('field1', 2));
      builder()->where($orx)->andWhere($orx)->orWhere($orx);
      """
    When I run Psalm
    Then I see these errors
      | DeprecatedMethod | The method Doctrine\DBAL\Query\Expression\ExpressionBuilder::orX has been marked as deprecated   |
      | DeprecatedMethod | The method Doctrine\DBAL\Query\Expression\CompositeExpression::add has been marked as deprecated |
      | DeprecatedMethod | The method Doctrine\DBAL\Query\Expression\CompositeExpression::add has been marked as deprecated |

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::where, ::orWhere and ::andWhere accept CompositeExpression
    Given I have the "doctrine/dbal" package satisfying the "< 2.11.0"
    And I have the following code
      """
      $expr = builder()->expr();
      $orx = $expr->orX();
      $orx->add($expr->eq('field1', 1));
      $orx->add($expr->eq('field1', 2));
      builder()->where($orx)->andWhere($orx)->orWhere($orx);
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::groupBy ::addGroupBy accept variadic arguments
    Given I have the following code
      """
      builder()->groupBy('field1', 'field2')
               ->addGroupBy('field1', 'field2');
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::groupBy ::addGroupBy accept array argument
    Given I have the following code
      """
      builder()->groupBy(['field1', 'field2'])
               ->addGroupBy(['field1', 'field2']);
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::having, ::orHaving and ::andHaving accept variadic arguments
    Given I have the following code
      """
      builder()->having('field1', 'field2')
               ->orHaving('field1', 'field2')
               ->andHaving('field1', 'field2');
      """
    When I run Psalm
    Then I see no errors

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::having, ::orHaving and ::andHaving accept CompositeExpression
    Given I have the "doctrine/dbal" package satisfying the ">= 2.11.0"
    And I have the following code
      """
      $andx = builder()->expr()->andX('a = b');
      builder()->having($andx)->orHaving($andx)->andHaving($andx);
      """
    When I run Psalm
    Then I see these errors
      | DeprecatedMethod | The method Doctrine\DBAL\Query\Expression\ExpressionBuilder::andX has been marked as deprecated |

  @QueryBuilderDbal
  Scenario: Dbal QueryBuilder ::having, ::orHaving and ::andHaving accept CompositeExpression
    Given I have the "doctrine/dbal" package satisfying the "< 2.11.0"
    And I have the following code
      """
      $andx = builder()->expr()->andX('a = b');
      builder()->having($andx)->orHaving($andx)->andHaving($andx);
      """
    When I run Psalm
    Then I see no errors
