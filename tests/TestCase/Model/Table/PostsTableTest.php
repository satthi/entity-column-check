<?php
namespace EntityColumnCheck\Test\TestCase\Model\Table;

use EntityColumnCheck\Test\App\Model\Table\PostsTable;
use Cake\TestSuite\TestCase;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Model\Table\PostsTable Test Case
 */
class PostsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.entity_column_check.posts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->connection = ConnectionManager::get('test');
        $this->Posts = new PostsTable([
            'alias' => 'Posts',
            'table' => 'posts',
            'connection' => $this->connection
        ]);

        //fixtureManagerを呼び出し、fixtureを実行する
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
        $this->fixtureManager->loadSingle('Posts');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Posts);
        parent::tearDown();
    }

    /**
     * test_newEntityCheck
     *
     * @return void
     */
    public function test_newEntityCheck()
    {
        $post = $this->Posts->newEntity();
        // とくにExceptionは吐かない
        $post->title;
        $post->test;
        $this->assertTrue(true);
    }

    /**
     * test_newEntityCheck
     *
     * @return void
     */
    public function test_EntityCheck()
    {
        $post = $this->Posts->get(1);
        $post->setProperty = 'test';
        $post->setPropertyNull = null;
        // とくにExceptionは吐かない
        $post->name;
        $post->entityProperty;
        $post->entityPropertyNull;
        $post->setProperty;
        $post->setPropertyNull;
        $post->_method;
        $post->entityColumnCheckAllowField;
        $this->assertTrue(true);
    }

    /**
     * test_nonPropertyEntityCheck
     * @expectedException Cake\Network\Exception\InternalErrorException
     * @expectedException Message invalid entity(EntityColumnCheck\Test\App\Model\Entity\Post) paramater(nonSetProperty)
     *
     * @return void
     */
    public function test_nonPropertyEntityCheck()
    {
        $post = $this->Posts->get(1);
        $post->nonSetProperty;
    }

}
