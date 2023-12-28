<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Tasks;

use App\Containers\AppSection\Authentication\Tasks\MakeRefreshCookieTask;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;

#[Group('authentication')]
#[CoversClass(MakeRefreshCookieTask::class)]
class MakeRefreshCookieTaskTest extends UnitTestCase
{
    public function testMakeRefreshCookie(): void
    {
        $refreshToken = 'some-random-refresh-token';
        $task = app(MakeRefreshCookieTask::class);

        $result = $task->run($refreshToken);

        // TODO: this should cover more cases
        $this->assertEquals($result->getName(), 'refreshToken');
        $this->assertEquals($result->getValue(), $refreshToken);
        $this->assertEquals($result->isHttpOnly(), true);
    }
}
