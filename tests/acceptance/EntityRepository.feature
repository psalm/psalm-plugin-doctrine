Feature: EntityRepository
  In order to use Doctrine EntityRepository safely
  As a Psalm user
  I need Psalm to typecheck EntityRepository

  Background:
    Given I have Doctrine plugin enabled
    And I have the following code preamble
      """
      <?php
      use Doctrine\ORM\EntityRepository;
      use Doctrine\Common\Collections\Collection;
      use Doctrine\Common\Collections\Criteria;

      interface I {}

      /**
       * @template T
       * @param class-string<T> $entityClass
       * @psalm-suppress InvalidReturnType
       * @return EntityRepository<T>
       */
      function repo(string $entityClass) {}

      """
    # Psalm enables cache when there's a composer.lock file
    And I have empty composer.lock

  @EntityRepository::find
  Scenario: Finding an entity by ID
    Given I have the following code
    """
    atan(repo(I::class)->find(1));
    """
    When I run Psalm
    Then I see these errors
        | Type            | Message                                            |
        | InvalidArgument | Argument 1 of atan expects float, I\|null provided |
    And I see no other errors

  @EntityRepository::findAll
  Scenario: Finding all entities
    Given I have the following code
    """
    atan(repo(I::class)->findAll());
    """
    When I run Psalm
    Then I see these errors
        | Type            | Message                                                        |
        | InvalidArgument | Argument 1 of atan expects float, list<I> provided |
    And I see no other errors

  @EntityRepository::findBy
  Scenario: Finding by criteria
    Given I have the following code
    """
    atan(repo(I::class)->findBy([]));
    """
    When I run Psalm
    Then I see these errors
        | Type            | Message                                                        |
        | InvalidArgument | Argument 1 of atan expects float, list<I> provided |
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
        | InvalidArgument | Argument 1 of atan expects float, I\|null provided |
    And I see no other errors

  @EntityRepository::matching
  Scenario: matching is typed
    Given I have the following code
      """
      /** @return Collection<int, I> */
      function f(): Collection {
        return repo(I::class)->matching(Criteria::create());
      }
      """
    When I run Psalm
    Then I see no errors
