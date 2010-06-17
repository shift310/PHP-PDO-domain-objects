<?php

class StmtTest extends \TestHelper
{
    protected $_stmt;

    public function setup()
    {
        parent::setup();
        $this->_stmt = $this->_pdo->query("SELECT * FROM messages");
    }

    public function testExceptionWhenQueryingNonexistantObject()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("not exist");
        $this->_stmt->fetchObjectOfClass('foo');
    }

    public function testExceptionWhenQueryingObjectOfTheWrongClass()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("should extend");
        $this->_stmt->fetchObjectOfClass('stdclass');
    }

    public function testQueryFetchesAnObject()
    {
        $message = $this->_stmt->fetchObjectOfClass('Messages');
        $this->assertEquals('Messages', get_class($message));
    }

    public function testQueryFetchesAllObjects()
    {
        $message = $this->_stmt->fetchAllObjectOfClass('Messages');
        $this->assertInternalType('array', $message);
        $this->assertGreaterThanOrEqual(1, count($message));
        $this->assertInternalType('object', $message[0]);
        $this->assertEquals('Messages', get_class($message[0]));
    }

    public function test__call()
    {
        $messages = $this->_stmt->fetchAllMessages();
        $message  = $this->_stmt->fetchOneMessages();
        $this->assertInternalType('object', $message);
        $this->assertInternalType('array', $messages);
    }
}