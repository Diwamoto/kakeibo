<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MstDepositsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MstDepositsTable Test Case
 */
class MstDepositsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MstDepositsTable
     */
    protected $MstDeposits;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
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
        $config = TableRegistry::getTableLocator()->exists('MstDeposits') ? [] : ['className' => MstDepositsTable::class];
        $this->MstDeposits = TableRegistry::getTableLocator()->get('MstDeposits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MstDeposits);

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
