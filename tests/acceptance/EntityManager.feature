Feature: EntityManager
  In order to use Doctrine EntityManager safely
  As a Psalm user
  I need Psalm to typecheck EntityManager

  Background:
    Given I have the following config
      """
      <?xml version="1.0"?>
      <psalm totallyTyped="true">
        <projectFiles>
          <directory name="."/>
        </projectFiles>
        <plugins>
          <pluginClass class="Weirdan\DoctrinePsalmPlugin\Plugin">
            <doctrine>
              <xml>
                <path>mapping</path>
              </xml>
            </doctrine>
          </pluginClass>
        </plugins>
      </psalm>
      """
    And I have the following mapping for "C"
      """
      <?xml version="1.0"?>
      <doctrine-mapping
        xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                            https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">
        <entity name="C" table="c">
        </entity>
      </doctrine-mapping>
      """
    And I have the following code preamble
      """
      <?php
      use Doctrine\ORM\EntityRepository;
      use Doctrine\ORM\EntityManager;

      class C {}

      /**
       * @psalm-suppress InvalidReturnType
       * @return EntityManager
       */
      function em() {}

      """

  @EntityManager::getRepository
  Scenario: EntityManager returns specialized EntityRepository
    Given I have the following code
      """
      atan(em()->getRepository(C::class));
      """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                                                     |
      | InvalidArgument | Argument 1 of atan expects float, Doctrine\ORM\EntityRepository<C> provided |
    And I see no other errors

  @EntityManager::getRepository
  Scenario: Getting repository for an invalid argument
    Given I have the following code
      """
      em()->getRepository(123);
      """
    When I run Psalm
    Then I see these errors
      | Type                  | Message                                                                                     |
      | InvalidScalarArgument | Argument 1 of Doctrine\ORM\EntityManager::getRepository expects class-string, int% provided |
    And I see no other errors

  @EntityManager::find
  Scenario: Finding an entity
    Given I have the following code
      """
      atan(em()->find(C::class, 1));
      """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                            |
      | InvalidArgument | Argument 1 of atan expects float, null\|C provided |
    And I see no other errors

  @EntityManager::find
  Scenario: Finding a non-entity
    Given I have the following code
    """
    em()->find(InvalidArgumentException::class, 1);
    """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                                                                                                      |
      | InvalidArgument | Argument 1 of Doctrine\ORM\EntityManager::find expects entity class, non-entity class-string(InvalidArgumentException) given |
    And I see no other errors

  @EntityManager::find
  Scenario: Calling find with a wrong argument type
    Given I have the following code
      """
      em()->find(123, 1);
      """
    When I run Psalm
    Then I see these errors
      | Type                  | Message                                                                            |
      | InvalidScalarArgument | Argument 1 of Doctrine\ORM\EntityManager::find expects class-string, int% provided |
    And I see no other errors

  @EntityManager::getReference
  Scenario: Getting a reference
    Given I have the following code
      """
      atan(em()->getReference(C::class, 1));
      """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                      |
      | InvalidArgument | Argument 1 of atan expects float, C provided |
    And I see no other errors

  @EntityManager::getReference
  Scenario: Calling getReference with a wrong argument type
    Given I have the following code
      """
      em()->getReference(123, 1);
      """
    When I run Psalm
    Then I see these errors
      | Type                  | Message                                                                                    |
      | InvalidScalarArgument | Argument 1 of Doctrine\ORM\EntityManager::getReference expects class-string, int% provided |
    And I see no other errors
