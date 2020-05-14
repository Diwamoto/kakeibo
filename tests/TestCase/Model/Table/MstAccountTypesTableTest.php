<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MstAccountTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MstAccountTypesTable Test Case
 */
class MstAccountTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MstAccountTypesTable
     */
    protected $MstAccountTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MstAccountTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MstAccountTypes') ? [] : ['className' => MstAccountTypesTable::class];
        $this->MstAccountTypes = TableRegistry::getTableLocator()->get('MstAccountTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MstAccountTypes);

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
