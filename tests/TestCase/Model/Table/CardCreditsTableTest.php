<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CardCreditsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CardCreditsTable Test Case
 */
class CardCreditsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CardCreditsTable
     */
    protected $CardCredits;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CardCredits',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CardCredits') ? [] : ['className' => CardCreditsTable::class];
        $this->CardCredits = TableRegistry::getTableLocator()->get('CardCredits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CardCredits);

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
