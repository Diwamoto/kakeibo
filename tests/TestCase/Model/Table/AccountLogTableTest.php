<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccountLogTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccountLogTable Test Case
 */
class AccountLogTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccountLogTable
     */
    protected $AccountLog;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.AccountLog',
        'app.Accounts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AccountLog') ? [] : ['className' => AccountLogTable::class];
        $this->AccountLog = TableRegistry::getTableLocator()->get('AccountLog', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AccountLog);

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
