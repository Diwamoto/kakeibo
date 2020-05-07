<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MstWithdrawsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MstWithdrawsTable Test Case
 */
class MstWithdrawsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MstWithdrawsTable
     */
    protected $MstWithdraws;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MstWithdraws',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MstWithdraws') ? [] : ['className' => MstWithdrawsTable::class];
        $this->MstWithdraws = TableRegistry::getTableLocator()->get('MstWithdraws', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MstWithdraws);

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
