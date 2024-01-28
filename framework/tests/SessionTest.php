<?php

namespace Anvts\Framework\Tests;

use Anvts\Framework\Session\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    protected function setUp(): void
    {
        unset($_SESSION);
    }

    public function testSetAndGetFlash()
    {
        $session = new Session();
        $session->setFlash('success', 'Success!');
        $session->setFlash('error', 'Something went wrong');

        $this->assertTrue($session->hasFlash('success'));
        $this->assertTrue($session->hasFlash('error'));

        $this->assertEquals(['Success!'], $session->getFlash('success'));
        $this->assertEquals(['Something went wrong'], $session->getFlash('error'));
        $this->assertEquals([], $session->getFlash('warning'));
    }
}