Feature: EntityManagerInterface
  In order to use Doctrine EntityManager safely
  As a Psalm user
  I need Psalm to typecheck EntityManagerInterface

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
      use Doctrine\ORM\EntityManagerInterface;
      use Doctrine\ORM\EntityRepository;

      interface I {}

      /**
       * @psalm-suppress InvalidReturnType
       * @return EntityManagerInterface
       */
      function em() {}

      """


  @EntityManagerInterface::getRepository
  Scenario: Getting repository for a class (entity)
    Given I have the following code
      """
      atan(em()->getRepository(I::class));
      """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                                                     |
      | InvalidArgument | Argument 1 of atan expects float, Doctrine\ORM\EntityRepository<I> provided |
    And I see no other errors

  @EntityManagerInterface::getRepository
  Scenario: Getting repository for an invalid argument
    Given I have the following code
      """
      em()->getRepository(123);
      """
    When I run Psalm
    Then I see these errors
      | Type                  | Message                                                                                              |
      | InvalidScalarArgument | Argument 1 of Doctrine\ORM\EntityManagerInterface::get%epository expects class-string, int% provided |
    And I see no other errors

  @EntityManagerInterface::find
  Scenario: Finding an entity
    Given I have the following code
      """
      atan(em()->find(I::class, 1));
      """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                            |
      | InvalidArgument | Argument 1 of atan expects float, null\|I provided |
    And I see no other errors

  @EntityManagerInterface::find
  Scenario: Calling find with a wrong argument type
    Given I have the following code
      """
      em()->find(123, 1);
      """
    When I run Psalm
    Then I see these errors
      | Type                  | Message                                                                                     |
      | InvalidScalarArgument | Argument 1 of Doctrine\ORM\EntityManagerInterface::find expects class-string, int% provided |
    And I see no other errors

  @EntityManagerInterface::getReference
  Scenario: Getting a reference
    Given I have the following code
      """
      atan(em()->getReference(I::class, 1));
      """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                      |
      | InvalidArgument | Argument 1 of atan expects float, I provided |
    And I see no other errors

  @EntityManagerInterface::getReference
  Scenario: Calling getReference with a wrong argument type
    Given I have the following code
      """
      em()->getReference(123, 1);
      """
    When I run Psalm
    Then I see these errors
      | Type                  | Message                                                                                             |
      | InvalidScalarArgument | Argument 1 of Doctrine\ORM\EntityManagerInterface::get%eference expects class-string, int% provided |
    And I see no other errors
