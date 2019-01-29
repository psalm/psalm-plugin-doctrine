Feature: Paginator
  In order to paginate Doctrine Queries safely
  As a Psalm user
  I need Psalm to typecheck Paginator

  Background:
    Given I have the following code preamble
      """
      <?php
          use Doctrine\ORM\Tools\Pagination\Paginator;

          interface I { public function aMethod(): void; }

          /**
           * @template T
           * @template-typeof T $type
           * @param class-string $type
           * @return Paginator<T>
           * @psalm-suppress InvalidReturnType
           */
          function paginate(string $type) {}

      """

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
