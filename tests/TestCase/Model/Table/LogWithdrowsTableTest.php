<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LogWithdrowsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LogWithdrowsTable Test Case
 */
class LogWithdrowsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LogWithdrowsTable
     */
    protected $LogWithdrows;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LogWithdrows',
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
        $config = TableRegistry::getTableLocator()->exists('LogWithdrows') ? [] : ['className' => LogWithdrowsTable::class];
        $this->LogWithdrows = TableRegistry::getTableLocator()->get('LogWithdrows', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LogWithdrows);

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
