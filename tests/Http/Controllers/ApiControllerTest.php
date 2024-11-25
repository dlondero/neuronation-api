<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Models\Session;
use App\Repositories\SessionRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class ApiControllerTest extends TestCase
{
    public function testGetProgressBadRequestLimit(): void
    {
        /** @var SessionRepository $userRepository */
        $userRepository = $this->createMock(SessionRepository::class);
        $request = new Request(['limit' => 'invalid']);
        $controller = new ApiController($userRepository);
        $response = $controller->getProgress($request, 1);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertSame('{"error":"Invalid limit parameter: must be an integer bigger than zero"}', $response->getContent());
    }

    public function testGetProgressBadRequestSort(): void
    {
        /** @var SessionRepository $userRepository */
        $userRepository = $this->createMock(SessionRepository::class);
        $request = new Request(['sort' => 'invalid']);
        $controller = new ApiController($userRepository);
        $response = $controller->getProgress($request, 1);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertSame('{"error":"Invalid sort parameter: only \"asc\" and \"desc\" are allowed"}', $response->getContent());
    }

    public function testGetProgressEmpty(): void
    {
        /** @var SessionRepository $userRepository */
        $userRepository = $this->createMock(SessionRepository::class);
        $userRepository->expects($this->once())
            ->method('getProgressByUserId')
            ->with(1, 25, 'desc')
            ->willReturn([]);

        $userRepository->expects($this->never())
            ->method('getCategoriesBySessionId');

        $request = new Request();
        $controller = new ApiController($userRepository);
        $response = $controller->getProgress($request, 1);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertSame(json_encode(['history'=> [], 'recent_categories' => []]), $response->getContent());
    }

    public function testGetProgress(): void
    {
        $history = [
            Session::fromArray([
                'session_id' => 1,
                'user_id' => 1,
                'session_stamp' => '1732478400',
                'total_score' => 100,
            ]),
            Session::fromArray([
                'session_id' => 2,
                'user_id' => 1,
                'session_stamp' => '1732564800',
                'total_score' => 100,
            ]),
        ];

        $expectedHistory = [
            'history' => [
                [
                    'session_date' => 1732478400,
                    'total_score' => 100,
                ],
                [
                    'session_date' => 1732564800,
                    'total_score' => 100,
                ],
            ],
            'recent_categories' => [
                'category1',
                'category2',
            ],
        ];

        /** @var SessionRepository $userRepository */
        $userRepository = $this->createMock(SessionRepository::class);
        $userRepository->expects($this->once())
            ->method('getProgressByUserId')
            ->with(1, 25, 'desc')
            ->willReturn($history);

        $userRepository->expects($this->once())
            ->method('getCategoriesBySessionId')
            ->with(2)
            ->willReturn(['category1', 'category2']);

        $request = new Request();
        $controller = new ApiController($userRepository);
        $response = $controller->getProgress($request, 1);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertSame(json_encode($expectedHistory), $response->getContent());
    }
}
