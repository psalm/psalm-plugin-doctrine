Feature: Tainting
  In order to prevent SQL injection when using Doctrine
  As a Psalm user
  I need Psalm to spot taint sources and sinks

  Background:
    Given I have Doctrine plugin enabled
    And I have the following code preamble
      """
      <?php
      use Doctrine\DBAL\Connection;

      /**
       * @psalm-suppress InvalidReturnType
       * @return Connection
       */
      function connection() {}

      """
    # Psalm enables cache when there's a composer.lock file
    And I have empty composer.lock

  @Connection::prepare
  @Connection::exec
  @Connection::query
  @Connection::executeUpdate
  @Connection::executeStatement
  Scenario Outline: Using user input on Connection's query methods
    Given I have the following code
      """
      $sql = 'INSERT INTO sometable (item_name) VALUES ("'.$_GET['untrusted'].'")';
      connection()-><method>($sql);
      """
    When I run Psalm with taint analysis
    Then I see these errors
      | Type                       | Message                       |
      | /TaintedInput\|TaintedSql/ | /Detected tainted (sql\|SQL)/ |
    And I see no other errors
  Examples:
    | method           |
    | prepare          |
    | exec             |
    | query            |
    | executeUpdate    |
    | executeStatement |

  @Connection::quote
  Scenario: Using Connection's quote method on user input
    Given I have the following code
      """
      $sql = 'SELECT * FROM sometable WHERE id=' . connection()->quote($_GET['untrusted']);
      connection()->query($sql);
      """
    When I run Psalm with taint analysis
    Then I see no errors
