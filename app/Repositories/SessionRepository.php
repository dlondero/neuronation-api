<?php

namespace App\Repositories;

use App\Models\Session;
use Illuminate\Support\Facades\DB;

class SessionRepository
{
    public function getProgressByUserId(int $userId, int $limit = 25, string $sort = 'desc'): array
    {
        $sorting = $sort === 'asc' ? 'ASC' : 'DESC';

        $result = DB::select("
            SELECT
                s.id AS session_id,
                s.user_id AS user_id,
                UNIX_TIMESTAMP(s.session_stamp) AS session_stamp,
                s.total_score AS total_score
            FROM
                sessions s
            WHERE
                s.user_id = ?
            ORDER BY
                s.session_stamp $sorting
            LIMIT ?
        ", [$userId, $limit]);

        return array_map(fn($row) => Session::fromArray((array) $row), $result);
    }

    public function getCategoriesBySessionId(int $sessionId): array
    {
        $categories = DB::select("
            SELECT DISTINCT
                c.name
            FROM
                session_exercises se
            JOIN
                exercises e ON se.exercise_id = e.id
            JOIN
                categories c ON e.category_id = c.id
            WHERE
                se.session_id = ?
        ", [$sessionId]);

        return array_map(fn($category) => $category->name, $categories);
    }
}
