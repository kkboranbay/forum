<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Spam;

class SpamTest extends TestCase
{
    /** @test */
    public function it_validates_spam()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));
    }
}
