Feature: Database taints
  In order to find stored injections when using Doctrine DBAL
  As a Psalm user
  I need Psalm to follow what queries store in each column to the queries reading it

  Background:
    Given I have Doctrine plugin enabled
    And I have the following code preamble
      """
      <?php
      use Doctrine\DBAL\Connection;

      function store(Connection $db): void {
          $db->executeStatement('INSERT INTO comments (author, body) VALUES (?, ?)', ['admin', $_GET['body']]);
      }

      """
    # Psalm enables cache when there's a composer.lock file
    And I have empty composer.lock

  Scenario: A column a query stored input in is tainted where a query reads it
    Given I have the following code
      """
      function show(Connection $db): void {
          $row = $db->fetchAssociative('SELECT author, body FROM comments');
          if ($row !== false) {
              echo (string) $row['body'];
          }
      }
      """
    When I run Psalm with taint analysis
    Then I see these errors
      | Type                  | Message                                            |
      | TaintedHtml           | Detected tainted HTML                              |
      | TaintedTextWithQuotes | Detected tainted text with possible quotes         |
    And I see no other errors

  Scenario Outline: The other columns are not tainted
    Given I have the following code
      """
      function show(Connection $db): void {
          echo (string) <read>;
      }
      """
    When I run Psalm with taint analysis
    Then I see no errors
  Examples:
    | read                                                                     |
    | $db->fetchOne('SELECT author FROM comments')                             |
    | ($db->fetchAssociative('SELECT author, body FROM comments') ?: [])['author'] |
    | $db->fetchOne('SELECT title FROM posts')                                 |

  Scenario: The rows of a prepared statement's result hold what an update with named parameters stored
    Given I have the "doctrine/dbal" package satisfying the ">= 4.0"
    And I have the following code
      """
      function update(Connection $db): void {
          $statement = $db->prepare('UPDATE users SET bio = :bio WHERE id = :id');
          $statement->bindValue('bio', $_GET['bio']);
          $statement->bindValue('id', 1);
          $statement->executeStatement();
      }

      function show(Connection $db): void {
          foreach ($db->prepare('SELECT bio FROM users')->executeQuery()->fetchAllAssociative() as $user) {
              echo (string) $user['bio'];
          }
      }
      """
    When I run Psalm with taint analysis
    Then I see these errors
      | Type                  | Message                                            |
      | TaintedHtml           | Detected tainted HTML                              |
      | TaintedTextWithQuotes | Detected tainted text with possible quotes         |
    And I see no other errors
