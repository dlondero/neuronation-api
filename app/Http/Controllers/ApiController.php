<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Repositories\SessionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ApiController extends Controller
{
    private const int DEFAULT_LIMIT = 25;
    private const string DEFAULT_SORT = 'desc';

    public function __construct(private readonly SessionRepository $sessionRepository)
    {
    }

    public function getProgress(Request $request, int $userId): JsonResponse
    {
        // Skipping authentication and authorization for simplicity, should be handled by middleware already present in
        // the existing API.

        // Validate the limit and sort parameters, ideally this should throw an exception handled by the global
        // exception handler to return a 400 response with a proper error message. For simplicity, we'll return a 400
        // response here. Additional parameters could be added based on frontend requirements.
        try {
            $this->validateRequest($request);
        } catch (InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], '400');
        }

        $limit = (int) $request->query('limit', (string) self::DEFAULT_LIMIT);
        $sort = (string) $request->query('sort', self::DEFAULT_SORT);

        $history = $this->sessionRepository->getProgressByUserId($userId, $limit, $sort);
        $categories = $this->getRecentCategories($history);

        return response()->json([
            'history' => array_map(fn(Session $session) => $session->toHistoryArray(), $history),
            'recent_categories' => $categories,
        ]);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validateRequest(Request $request): void
    {
        $limit = $request->query('limit');
        $sort = $request->query('sort');
        if (null !== $limit && (!is_numeric($limit) || $limit < 1)) {
            throw new InvalidArgumentException('Invalid limit parameter: must be an integer bigger than zero');
        }
        if (null !== $sort && !in_array($sort, ['asc', 'desc'])) {
            throw new InvalidArgumentException('Invalid sort parameter: only "asc" and "desc" are allowed');
        }
    }

    private function getRecentCategories(array $history): array
    {
        if (empty($history)) {
            return [];
        }

        // Sort the history by session stamp in descending order in memory to always get the last session
        // without making another query to the database independently of the sort order from the request
        usort($history, fn(Session $a, Session $b) => $b->sessionStamp() <=> $a->sessionStamp());
        $lastSessionId = $history[0]->id();

        return $this->sessionRepository->getCategoriesBySessionId($lastSessionId);
    }
}
