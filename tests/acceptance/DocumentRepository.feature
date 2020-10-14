Feature: DocumentRepository
  In order to use Doctrine DocumentRepository safely
  As a Psalm user
  I need Psalm to typecheck DocumentRepository

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
      use Doctrine\Common\Collections\Collection;
      use Doctrine\Common\Collections\Criteria;
      use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

      interface I {}

      /**
       * @template T
       * @param class-string<T> $documentClass
       * @psalm-suppress InvalidReturnType
       * @return DocumentRepository<T>
       */
      function repo(string $documentClass) {}

      """

  @DocumentRepository::find
  Scenario: Finding an document by ID
    Given I have the following code
    """
    atan(repo(I::class)->find(1));
    """
    When I run Psalm
    Then I see these errors
        | Type            | Message                                            |
        | InvalidArgument | Argument 1 of atan expects float, I\|null provided |
    And I see no other errors

  @DocumentRepository::findAll
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

  @DocumentRepository::findBy
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

  @DocumentRepository::findOneBy
  Scenario: Finding one document by criteria
    Given I have the following code
    """
    atan(repo(I::class)->findOneBy([]));
    """
    When I run Psalm
    Then I see these errors
        | Type            | Message                                            |
        | InvalidArgument | Argument 1 of atan expects float, I\|null provided |
    And I see no other errors
