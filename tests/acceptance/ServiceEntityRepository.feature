Feature: ServiceEntityRepository
  In order to use simplified repository safely
  As a Psalm user
  I need Psalm to typecheck ServiceEntityRepository

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
        <issueHandlers>
          <DeprecatedClass>
            <errorLevel type="suppress">
              <referencedClass name="Symfony\Bridge\Doctrine\RegistryInterface"/>
            </errorLevel>
          </DeprecatedClass>
        </issueHandlers>
      </psalm>
      """
    And I have the following code preamble
      """
      <?php
      use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
      use Symfony\Bridge\Doctrine\RegistryInterface;

      interface I {}
      """

    @ServiceEntityRepository::inheritance
    Scenario: Extending a ServiceEntityRepository
    Given I have the following code
    """
    /**
     * @method I|null find($id, $lockMode = null, $lockVersion = null)
     * @method I|null findOneBy(array $criteria, array $orderBy = null)
     * @method list<I>    findAll()
     * @method list<I>    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     * @template-extends ServiceEntityRepository<I>
     * @psalm-suppress PropertyNotSetInConstructor
     */
    class IRepository extends ServiceEntityRepository {
      public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, I::class);
      }
    }
    """
    When I run Psalm
    Then I see no errors
