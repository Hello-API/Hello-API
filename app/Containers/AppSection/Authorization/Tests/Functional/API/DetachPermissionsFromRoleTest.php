<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Data\Factories\PermissionFactory;
use App\Containers\AppSection\Authorization\Data\Factories\RoleFactory;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\Group;

#[Group('authorization')]
class DetachPermissionsFromRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/permissions/detach';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testDetachSinglePermissionFromRole(): void
    {
        $permissionA = PermissionFactory::new()->createOne();
        $permissionB = PermissionFactory::new()->createOne();
        $role = RoleFactory::new()->createOne();
        $role->givePermissionTo([$permissionA, $permissionB]);
        $data = [
            'role_id' => $role->getHashedKey(),
            'permissions_ids' => [$permissionA->getHashedKey()],
        ];

        $response = $this->makeCall($data);

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('data')
                ->where('data.object', 'Role')
                ->where('data.id', $role->getHashedKey())
                ->count('data.permissions.data', 1)
                ->where('data.permissions.data.0.id', $permissionB->getHashedKey())
                ->etc(),
        );
    }

    public function testDetachMultiplePermissionFromRole(): void
    {
        $permissionA = PermissionFactory::new()->createOne();
        $permissionB = PermissionFactory::new()->createOne();
        $permissionC = PermissionFactory::new()->createOne();
        $role = RoleFactory::new()->createOne();
        $role->givePermissionTo([$permissionA, $permissionB, $permissionC]);
        $data = [
            'role_id' => $role->getHashedKey(),
            'permissions_ids' => [$permissionA->getHashedKey(), $permissionC->getHashedKey()],
        ];

        $response = $this->makeCall($data);

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('data')
                ->where('data.object', 'Role')
                ->where('data.id', $role->getHashedKey())
                ->count('data.permissions.data', 1)
                ->where('data.permissions.data.0.id', $permissionB->getHashedKey())
                ->etc(),
        );
    }

    public function testDetachPermissionFromNonExistingRole(): void
    {
        $permission = PermissionFactory::new()->createOne();
        $invalidId = 7777;
        $data = [
            'role_id' => $this->encode($invalidId),
            'permissions_ids' => [$permission->getHashedKey()],
        ];

        $response = $this->makeCall($data);

        $response->assertUnprocessable();
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('errors')
                ->where('errors.role_id.0', 'The selected role id is invalid.')
                ->etc(),
        );
    }

    public function testDetachNonExistingPermissionFromRole(): void
    {
        $role = RoleFactory::new()->createOne();
        $invalidId = 7777;
        $data = [
            'role_id' => $role->getHashedKey(),
            'permissions_ids' => [$this->encode($invalidId)],
        ];

        $response = $this->makeCall($data);

        $response->assertJson(
            fn (AssertableJson $json) => $json->has(
                'errors',
                fn (AssertableJson $errors) => $errors->has(
                    'permissions_ids.0',
                    fn (AssertableJson $permissionsIds) => $permissionsIds->where(0, 'The selected permissions_ids.0 is invalid.'),
                )->etc(),
            )->etc(),
        );
    }
}
