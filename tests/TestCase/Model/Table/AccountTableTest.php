<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccountTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccountTable Test Case
 */
class AccountTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccountTable
     */
    protected $Account;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Account',
        'app.User',
        'app.AccountLog',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Account') ? [] : ['className' => AccountTable::class];
        $this->Account = TableRegistry::getTableLocator()->get('Account', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Account);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
