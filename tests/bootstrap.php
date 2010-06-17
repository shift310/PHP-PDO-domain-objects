<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use JPDO\Result\SavableObjects;

require __DIR__ . '/../vendor/autoload.php';

abstract class TestHelper extends TestCase
{
    use TestCaseTrait;
    protected $_pdo;

    public function getConnection()
    {
        return $this->createDefaultDBConnection($this->_pdo, ':memory:');
    }

    public function getDataSet()
    {
        return $this->createFlatXmlDataset(DATA_PATH . '/dataset.xml');
    }

    public function __invoke()
    {
        return $this->getConnection()->createDataSet();
    }

    protected function setup()
    {
        $this->_pdo = new JPDO\PDO('sqlite::memory:');
        $this->_pdo->exec("CREATE table messages (id integer, message text);");
        parent::setup();
    }
}

class Messages extends SavableObjects { }