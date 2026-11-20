Feature: Connection
  In order to use Doctrine DBAL Connection safely
  As a Psalm user
  I need Psalm to typecheck the parameter types of Connection's query methods

  Background:
    Given I have Doctrine plugin enabled
    And I have the following code preamble
      """
      <?php
      use Doctrine\DBAL\ArrayParameterType;
      use Doctrine\DBAL\Connection;
      use Doctrine\DBAL\ParameterType;
      use Doctrine\DBAL\Types\Type;

      /**
       * @psalm-suppress InvalidReturnType
       * @return Connection
       * @psalm-capabilities read-props
       */
      function connection() {}

      /**
       * @psalm-suppress InvalidReturnType
       * @return Type
       * @psalm-capabilities read-props
       */
      function type() {}

      """
    # Psalm enables cache when there's a composer.lock file
    And I have empty composer.lock

  @Connection::executeQuery
  @Connection::executeStatement
  @Connection::fetchAssociative
  @Connection::fetchNumeric
  @Connection::fetchOne
  @Connection::fetchAllNumeric
  @Connection::fetchAllAssociative
  @Connection::fetchAllKeyValue
  @Connection::fetchAllAssociativeIndexed
  @Connection::fetchFirstColumn
  @Connection::iterateNumeric
  @Connection::iterateAssociative
  @Connection::iterateKeyValue
  @Connection::iterateAssociativeIndexed
  @Connection::iterateColumn
  Scenario Outline: Passing named parameter types to Connection's query methods
    Given I have the "doctrine/dbal" package satisfying the ">= 4.0"
    And I have the following code
      """
      connection()-><method>(
        'SELECT a FROM t WHERE a = :a AND b IN (:b) AND c = :c AND d = :d',
        ['a' => 1, 'b' => [1, 2], 'c' => 'x', 'd' => 'y'],
        ['a' => ParameterType::INTEGER, 'b' => ArrayParameterType::INTEGER, 'c' => 'string', 'd' => type()],
      );
      """
    When I run Psalm
    Then I see no errors
  Examples:
    | method                     |
    | executeQuery               |
    | executeStatement           |
    | fetchAssociative           |
    | fetchNumeric               |
    | fetchOne                   |
    | fetchAllNumeric            |
    | fetchAllAssociative        |
    | fetchAllKeyValue           |
    | fetchAllAssociativeIndexed |
    | fetchFirstColumn           |
    | iterateNumeric             |
    | iterateAssociative         |
    | iterateKeyValue            |
    | iterateAssociativeIndexed  |
    | iterateColumn              |

  @Connection::fetchOne
  Scenario: Passing positional parameter types to Connection's query methods
    Given I have the "doctrine/dbal" package satisfying the ">= 4.0"
    And I have the following code
      """
      connection()->fetchOne('SELECT a FROM t WHERE a = ? AND b = ?', [1, 'x'], [ParameterType::INTEGER, 'string']);
      """
    When I run Psalm
    Then I see no errors

  @Connection::fetchOne
  Scenario: Passing an invalid parameter type to Connection's query methods
    Given I have the "doctrine/dbal" package satisfying the ">= 4.0"
    And I have the following code
      """
      connection()->fetchOne('SELECT a FROM t WHERE a = :a', ['a' => 1], ['a' => 1.5]);
      """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                                                                 |
      | InvalidArgument | /Argument 3 of .*Connection::fetchOne expects .*, but array{a: float\(1\.5\)} provided/ |
    And I see no other errors
