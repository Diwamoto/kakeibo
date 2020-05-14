<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\KakeiboComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\KakeiboComponent Test Case
 */
class KakeiboComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\TestComponent
     */
    protected $Test;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Kakeibo = new KakeiboComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Kakeibo);

        parent::tearDown();
    }
}
