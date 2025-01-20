<?php

namespace App\Containers\AppSection\User\Tests\Functional\API;

use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class ListUsersTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/users';

    protected array $access = [
        'permissions' => null,
        'roles' => null,
    ];

    public function testCanIndexUsersAsAdmin(): void
    {
        $this->testingUser = UserFactory::new()->admin()->createOne();
        UserFactory::new()->count(2)->create();

        $response = $this->makeCall();

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data', 4)
                ->etc(),
        );
    }
}
