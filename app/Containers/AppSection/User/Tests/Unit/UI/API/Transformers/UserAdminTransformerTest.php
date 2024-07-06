<?php

namespace App\Containers\AppSection\User\Tests\Unit\UI\API\Transformers;

use App\Containers\AppSection\User\Contracts\Transformers\IncludePermissions;
use App\Containers\AppSection\User\Contracts\Transformers\IncludeRoles;
use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\UI\API\Transformers\UserAdminTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;

#[Group('user')]
#[CoversClass(UserAdminTransformer::class)]
final class UserAdminTransformerTest extends UnitTestCase
{
    private UserAdminTransformer $transformer;

    public function testImplementsContract(): void
    {
        $this->assertInstanceOf(IncludeRoles::class, $this->transformer);
        $this->assertInstanceOf(IncludePermissions::class, $this->transformer);
    }

    public function testCanTransformSingleObject(): void
    {
        $user = UserFactory::new()->createOne();
        $expected = [
            'object' => $user->getResourceKey(),
            'id' => $user->getHashedKey(),
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'gender' => $user->gender,
            'birth' => $user->birth,
            'real_id' => $user->id,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'readable_created_at' => $user->created_at->diffForHumans(),
            'readable_updated_at' => $user->updated_at->diffForHumans(),
        ];

        $transformedResource = $this->transformer->transform($user);

        $this->assertEquals($expected, $transformedResource);
    }

    public function testAvailableIncludes(): void
    {
        $this->assertSame([
            'roles',
            'permissions',
        ], $this->transformer->getAvailableIncludes());
    }

    public function testDefaultIncludes(): void
    {
        $this->assertSame([], $this->transformer->getDefaultIncludes());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new UserAdminTransformer();
    }
}
