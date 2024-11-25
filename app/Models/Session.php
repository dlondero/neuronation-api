<?php

namespace App\Models;

use DateTimeImmutable;

class Session
{
    private int $id;
    private int $userId;
    private DateTimeImmutable $sessionStamp;
    private int $totalScore;

    public function id(): int
    {
        return $this->id;
    }

    public function sessionStamp(): DateTimeImmutable
    {
        return $this->sessionStamp;
    }

    public function toHistoryArray(): array
    {
        return [
            'session_date' => $this->sessionStamp->getTimestamp(),
            'total_score' => $this->totalScore,
        ];
    }

    public static function fromArray(array $data): self
    {
        $session = new self();
        $session->id = (int) $data['session_id'];
        $session->userId = (int) $data['user_id'];
        $session->sessionStamp = DateTimeImmutable::createFromFormat('U', (string) $data['session_stamp']);
        $session->totalScore = (int) $data['total_score'];

        return $session;
    }
}
