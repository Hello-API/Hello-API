<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\User\Models\User;
use App\Containers\Authorization\Tests\TestCase;

/**
 * Class AssignUserToRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class AssignUserToRoleTest extends TestCase
{

    protected $endpoint = '/roles/assign';

    protected $access = [
        'roles'       => 'admin',
        'permissions' => '',
    ];

    public function testAssignUserToRole_()
    {
        $this->getTestingAdmin();

        $randomUser = factory(User::class)->create();

        $data = [
            'roles_names' => 'admin',
            'user_id'     => $randomUser->getHashedKey(),
        ];

        // send the HTTP request
        $response = $this->apiCall($this->endpoint, 'post', $data, true);

        // assert response status is correct
        $this->assertEquals('200', $response->getStatusCode());

        $responseObject = $this->getResponseObject($response);

        $this->assertEquals($data['user_id'], $responseObject->data->id);

        $this->assertEquals($data['roles_names'], $responseObject->data->roles->data[0]->name);
    }

    public function testAssignUserToRoleWithRealId_()
    {
        $this->getTestingAdmin();

        $randomUser = factory(User::class)->create();

        $data = [
            'roles_names' => 'admin',
            'user_id'     => $randomUser->id,
        ];

        // send the HTTP request
        $response = $this->apiCall($this->endpoint, 'post', $data, true);

        // assert response status is correct. Note: this will return 200 if `HASH_ID=false` in the .env
        $this->assertEquals('400', $response->getStatusCode());

        $this->assertResponseContainKeyValue([
            'message' => 'Only Hashed ID\'s allowed to be passed.',
        ], $response);
    }

    public function testAssignUserToManyRoles_()
    {
        $this->getTestingUser();

        $randomUser = factory(User::class)->create();

        $data = [
            'roles_names' => ['admin', 'client'],
            'user_id'     => $randomUser->getHashedKey(),
        ];

        // send the HTTP request
        $response = $this->apiCall($this->endpoint, 'post', $data, true);

        // assert response status is correct
        $this->assertEquals('200', $response->getStatusCode());

        $responseObject = $this->getResponseObject($response);

        $this->assertTrue(count($responseObject->data->roles->data) > 1);

        $this->assertEquals($data['roles_names'][0], $responseObject->data->roles->data[0]->name);

        $this->assertEquals($data['roles_names'][1], $responseObject->data->roles->data[1]->name);
    }

}
