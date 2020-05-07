<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LogDepositsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LogDepositsTable Test Case
 */
class LogDepositsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LogDepositsTable
     */
    protected $LogDeposits;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LogDeposits',
        'app.Users',
        'app.MstPaymentMethods',
        'app.Accounts',
        'app.MstDeposits',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LogDeposits') ? [] : ['className' => LogDepositsTable::class];
        $this->LogDeposits = TableRegistry::getTableLocator()->get('LogDeposits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LogDeposits);

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
