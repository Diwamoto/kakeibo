<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LogWithdrawsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LogWithdrawsTable Test Case
 */
class LogWithdrawsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LogWithdrawsTable
     */
    protected $LogWithdraws;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LogWithdraws',
        'app.Users',
        'app.MstWithdraws',
        'app.Accounts',
        'app.MstPaymentMethods',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LogWithdraws') ? [] : ['className' => LogWithdrawsTable::class];
        $this->LogWithdraws = TableRegistry::getTableLocator()->get('LogWithdraws', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LogWithdraws);

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
