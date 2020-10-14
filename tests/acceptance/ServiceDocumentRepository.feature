Feature: ServiceDocumentRepository
  In order to use simplified repository safely
  As a Psalm user
  I need Psalm to typecheck ServiceDocumentRepository

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
      use Doctrine\Bundle\DoctrineBundle\Repository\ServiceDocumentRepository;
      """

    @ServiceDocumentRepository::inheritance
    Scenario: Extending a ServiceDocumentRepository
      Given I have the "doctrine/persistence" package satisfying the "< 1.3"
      And I have the following code
        """
        use Doctrine\Common\Persistence\ManagerRegistry as RegistryInterface;

        interface I {}
        /**
         * @method I|null find($id, $lockMode = null, $lockVersion = null)
         * @method I|null findOneBy(array $criteria, array $orderBy = null)
         * @method list<I>    findAll()
         * @method list<I>    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
         * @template-extends ServiceDocumentRepository<I>
         * @psalm-suppress PropertyNotSetInConstructor
         */
        class IRepository extends ServiceDocumentRepository {
          public function __construct(RegistryInterface $registry) {
            parent::__construct($registry, I::class);
          }
        }
        """
      When I run Psalm
      Then I see no errors

    @ServiceDocumentRepository::inheritance
      Scenario: Extending a ServiceDocumentRepository
      Given I have the "doctrine/persistence" package satisfying the ">= 1.3"
      And I have the following code
        """
        use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

        interface I {}
        /**
         * @method I|null find($id, $lockMode = null, $lockVersion = null)
         * @method I|null findOneBy(array $criteria, array $orderBy = null)
         * @method list<I>    findAll()
         * @method list<I>    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
         * @template-extends ServiceDocumentRepository<I>
         * @psalm-suppress PropertyNotSetInConstructor
         */
        class IRepository extends ServiceDocumentRepository {
          public function __construct(RegistryInterface $registry) {
            parent::__construct($registry, I::class);
          }
        }
        """
      When I run Psalm
      Then I see no errors

