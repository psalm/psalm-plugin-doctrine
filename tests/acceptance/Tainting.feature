Feature: Tainting
  In order to prevent SQL injection when using Doctrine
  As a Psalm user
  I need Psalm to spot taint sources and sinks

  Background:
    Given I have Psalm newer than "3.12" (because of "taint analysis")
    And I have the following config
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
      use Doctrine\DBAL\Connection;

      /**
       * @psalm-suppress InvalidReturnType
       * @return Connection
       */
      function connection() {}

      """

  @Connection::prepare
  @Connection::exec
  @Connection::query
  @Connection::executeUpdate
  Scenario Outline: Using user input on Connection's query methods
    Given I have the following code
      """
      $sql = 'INSERT INTO sometable (item_name) VALUES ("'.$_GET['untrusted'].'")';
      connection()-><method>($sql);
      """
    When I run Psalm with taint analysis
    Then I see these errors
      | Type         | Message              |
      | TaintedInput | Detected tainted sql |
    And I see no other errors
  Examples:
    | method        |
    | prepare       |
    | exec          |
    | query         |
    | executeUpdate |

  @Connection::quote
  Scenario: Using Connection's quote method on user input
    Given I have the following code
      """
      $sql = 'SELECT * FROM sometable WHERE id=' . connection()->quote($_GET['untrusted']);
      connection()->query($sql);
      """
    When I run Psalm with taint analysis
    Then I see no errors
