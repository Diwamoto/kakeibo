<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserTokensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserTokensTable Test Case
 */
class UserTokensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserTokensTable
     */
    protected $UserTokens;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserTokens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UserTokens') ? [] : ['className' => UserTokensTable::class];
        $this->UserTokens = TableRegistry::getTableLocator()->get('UserTokens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserTokens);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
