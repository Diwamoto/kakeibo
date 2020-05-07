<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MstPaymentMethodsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MstPaymentMethodsTable Test Case
 */
class MstPaymentMethodsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MstPaymentMethodsTable
     */
    protected $MstPaymentMethods;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
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
        $config = TableRegistry::getTableLocator()->exists('MstPaymentMethods') ? [] : ['className' => MstPaymentMethodsTable::class];
        $this->MstPaymentMethods = TableRegistry::getTableLocator()->get('MstPaymentMethods', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MstPaymentMethods);

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
