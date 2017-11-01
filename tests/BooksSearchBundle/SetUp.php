<?php
namespace Tests\BooksSearchBundle;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-10-31 at 22:00:10.
 */
class BookRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    protected function executeCmd($cmd)
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        
        $updateCommand = $application->find($cmd);

        $updateArguments = array(
            'command' => $cmd,
//            '--force' => true
        );

        $updateInput = new ArrayInput($updateArguments);
        $updateInput->setInteractive(false);
        $updateCommand->run($updateInput, new ConsoleOutput());
    }
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();
        
        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        
        // get real count from DB
//        $conn = $this->em->getConnection();
//        $stmt = $conn->prepare("DROP database books_search;");
//        $stmt->execute();

//        $this->executeCmd('doctrine:database:drop');
//        $this->executeCmd('doctrine:database:create');
//        $this->executeCmd('doctrine:schema:update');
//        $this->executeCmd('doctrine:fixtures:load');

    }
    
    public function testMock()
    {
    }

}