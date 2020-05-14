<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\MoneyComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\MoneyComponent Test Case
 */
class MoneyComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\MoneyComponent
     */
    protected $Money;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Money = new MoneyComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Money);

        parent::tearDown();
    }
}
