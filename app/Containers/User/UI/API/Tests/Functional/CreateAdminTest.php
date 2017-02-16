<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\User\Tests\TestCase;

/**
 * Class CreateAdminTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateAdminTest extends TestCase
{

    protected $endpoint = '/admins/create';

    public function testCreateAdmin_()
    {
        $this->getTestingAdmin(); // since we're using Admin here, we don't need to specify $access['role'] => 'admin'

        $data = [
            'email'    => 'hello@admin.dev',
            'name'     => 'admin',
            'password' => 'secret',
        ];

        // send the HTTP request
        $response = $this->apiCall($this->endpoint, 'post', $data);

        // assert response status is correct
        $this->assertEquals('200', $response->getStatusCode());

        $this->assertResponseContainKeyValue([
            'email' => $data['email'],
            'name'  => $data['name'],
        ], $response);

         // assert response contain the token
        $this->assertResponseContainKeys(['id', 'token'], $response);

         // assert the data is stored in the database
        $this->seeInDatabase('users', ['email' => $data['email']]);

        $responseObject = $this->getResponseObject($response);

        $this->assertEquals($responseObject->data->roles->data[0]->name, $data['name']);
    }

}
