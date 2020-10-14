Feature: DocumentManager
  In order to use Doctrine DocumentManager safely
  As a Psalm user
  I need Psalm to typecheck DocumentManager

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
      use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
      use Doctrine\ODM\MongoDB\DocumentManager;

      interface I {}

      /**
       * @psalm-suppress InvalidReturnType
       * @return DocumentManager
       */
      function dm() {}

      """

  @DocumentManager::getRepository
  Scenario: DocumentManager returns specialized DocumentRepository
    Given I have the following code
      """
      atan(dm()->getRepository(I::class));
      """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                                                     |
      | InvalidArgument | Argument 1 of atan expects float, Doctrine\ODM\MongoDB\Repository\DocumentRepository<I> provided |
    And I see no other errors

  @DocumentManager::getRepository
  Scenario: Getting repository for an invalid argument
    Given I have the following code
      """
      dm()->getRepository(123);
      """
    When I run Psalm
    Then I see these errors
      | Type                  | Message                                                                                         |
      | InvalidScalarArgument | Argument 1 of Doctrine\ODM\MongoDB\DocumentManager::getRepository expects class-string, int(123) provided |
    And I see no other errors

  @DocumentManager::find
  Scenario: Finding an entity
    Given I have the following code
      """
      atan(dm()->find(I::class, 1));
      """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                            |
      | InvalidArgument | Argument 1 of atan expects float, I\|null provided |
    And I see no other errors

  @DocumentManager::find
  Scenario: Calling find with a wrong argument type
    Given I have the following code
      """
      dm()->find(123, 1);
      """
    When I run Psalm
    Then I see these errors
      | Type                  | Message                                                                                |
      | InvalidScalarArgument | Argument 1 of Doctrine\ODM\MongoDB\DocumentManager::find expects class-string, int(123) provided |
    And I see no other errors

  @DocumentManager::getReference
  Scenario: Getting a reference
    Given I have the following code
      """
      atan(dm()->getReference(I::class, 1));
      """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                            |
      | InvalidArgument | Argument 1 of atan expects float, I provided |
    And I see no other errors

  @DocumentManager::getReference
  Scenario: Calling getReference with a wrong argument type
    Given I have the following code
      """
      dm()->getReference(123, 1);
      """
    When I run Psalm
    Then I see these errors
      | Type                  | Message                                                                                        |
      | InvalidScalarArgument | Argument 1 of Doctrine\ODM\MongoDB\DocumentManager::getReference expects class-string, int(123) provided |
    And I see no other errors

  @DocumentManager::inheritance
  Scenario: Can extend DocumentManager
    Given I have the following code
      """
      class MyManager extends DocumentManager {}
      """
    When I run Psalm
    Then I see no errors
