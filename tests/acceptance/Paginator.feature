Feature: Paginator
  In order to paginate Doctrine Queries safely
  As a Psalm user
  I need Psalm to typecheck Paginator

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
          use Doctrine\ORM\Tools\Pagination\Paginator;

          interface I { public function aMethod(): void; }

          /**
           * @template T
           * @param class-string<T> $type
           * @return Paginator<T>
           * @psalm-suppress InvalidReturnType
           */
          function paginate(string $type) {}

      """
    # Psalm enables cache when there's a composer.lock file
    And I have empty composer.lock

  @Paginator
  Scenario: Paginator allows iteration
    Given I have the following code
      """
      foreach (paginate(I::class) as $v) {}
      """
    When I run Psalm
    Then I see no errors

  @Paginator
  Scenario: Paginator provides typed elements for iteration
    Given I have the following code
      """
      foreach (paginate(I::class) as $v) {
        $v->aMethod();
        atan($v);
      }
      """
    When I run Psalm
    Then I see these errors
      | Type            | Message                                      |
      | InvalidArgument | Argument 1 of atan expects float, I provided |
    And I see no other errors
