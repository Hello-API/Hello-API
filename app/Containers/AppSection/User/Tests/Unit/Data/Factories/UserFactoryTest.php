<?php

namespace App\Containers\AppSection\User\Tests\Unit\Data\Factories;

use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;

/**
 * @group user
 * @group unit
 */
class UserFactoryTest extends UnitTestCase
{
    public function testCreateUser(): void
    {
        $user = UserFactory::new()->createOne();

        $this->assertInstanceOf(User::class, $user);
    }

    public function testCreateAdminUser(): void
    {
        $user = UserFactory::new()->admin()->createOne();

        $this->assertTrue($user->hasRole(config('appSection-authorization.admin_role')));
    }

    public function testCreateUnverifiedUser(): void
    {
        $user = UserFactory::new()->unverified()->createOne();

        $this->assertNull($user->email_verified_at);
    }
}
