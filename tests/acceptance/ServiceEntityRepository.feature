Feature: ServiceEntityRepository
  In order to use simplified repository safely
  As a Psalm user
  I need Psalm to typecheck ServiceEntityRepository

  Background:
    Given I have Doctrine plugin enabled
    And I have the following code preamble
      """
      <?php
      use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
      """
    # Psalm enables cache when there's a composer.lock file
    And I have empty composer.lock

    @ServiceEntityRepository::inheritance
    Scenario: Extending a ServiceEntityRepository
      Given I have the "doctrine/persistence" package satisfying the "< 1.3"
      And I have the following code
        """
        use Doctrine\Persistence\ManagerRegistry;

        interface I {}
        /**
         * @method I|null find($id, $lockMode = null, $lockVersion = null)
         * @method I|null findOneBy(array $criteria, array $orderBy = null)
         * @method list<I>    findAll()
         * @method list<I>    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
         * @template-extends ServiceEntityRepository<I>
         * @psalm-suppress PropertyNotSetInConstructor
         */
        class IRepository extends ServiceEntityRepository {
          public function __construct(ManagerRegistry $registry) {
            parent::__construct($registry, I::class);
          }
        }
        """
      When I run Psalm
      Then I see no errors
