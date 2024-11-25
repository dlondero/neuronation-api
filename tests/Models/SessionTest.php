<?php

namespace Tests\Models;

use App\Models\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    private Session $session;
    protected function setUp(): void
    {
        $this->session = Session::fromArray([
            'session_id' => 1,
            'user_id' => 1,
            'session_stamp' => '1732564800',
            'total_score' => 100,
        ]);
    }

    public function testSessionId(): void
    {
        $this->assertEquals(1, $this->session->id());
    }

    public function testSessionStamp(): void
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->session->sessionStamp());
        $this->assertSame('2024-11-25 20:00:00', $this->session->sessionStamp()->format('Y-m-d H:i:s'));
    }

    public function testToHistoryArray(): void
    {
        $this->assertEquals([
            'session_date' => 1732564800,
            'total_score' => 100,
        ], $this->session->toHistoryArray());
    }

    public function testFromArray(): void
    {
        $session = Session::fromArray([
            'session_id' => 1,
            'user_id' => 1,
            'session_stamp' => '1732564800',
            'total_score' => 100,
        ]);

        $this->assertInstanceOf(Session::class, $session);
    }
}
