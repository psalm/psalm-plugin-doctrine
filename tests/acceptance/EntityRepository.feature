Feature: EntityRepository
  In order to use Doctrine EntityRepository safely
  As a Psalm user
  I need Psalm to typecheck EntityRepository

  Background:
    Given I have the following code preamble
      """
      <?php
      use Doctrine\ORM\EntityRepository;

      interface I {}

      /**
       * @template T
       * @template-typeof T $entityClass
       * @psalm-suppress InvalidReturnType
       * @return EntityRepository<T>
       */
      function repo(string $entityClass) {}

      """

  @EntityRepository::findAll
  Scenario: Finding all entities
    Given I have the following code
    """
    atan(repo(I::class)->findAll());
    """
    When I run Psalm
    Then I see these errors
        | Type            | Message                                                |
        | InvalidArgument | Argument 1 of atan expects float, array<%, I> provided |
    And I see no other errors

  @EntityRepository::findBy
  Scenario: Finding by criteria
    Given I have the following code
    """
    atan(repo(I::class)->findBy([]));
    """
    When I run Psalm
    Then I see these errors
        | Type            | Message                                                |
        | InvalidArgument | Argument 1 of atan expects float, array<%, I> provided |
    And I see no other errors

  @EntityRepository::findOneBy
  Scenario: Finding one entity by criteria
    Given I have the following code
    """
    atan(repo(I::class)->findOneBy([]));
    """
    When I run Psalm
    Then I see these errors
        | Type            | Message                                            |
        | InvalidArgument | Argument 1 of atan expects float, null\|I provided |
    And I see no other errors
