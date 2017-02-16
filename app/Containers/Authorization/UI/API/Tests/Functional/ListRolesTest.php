<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\User;
use App\Containers\Authorization\Tests\TestCase;

/**
 * Class ListRolesTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class ListRolesTest extends TestCase
{

    protected $endpoint = '/roles';

    protected $access = [
        'roles'       => 'admin',
        'permissions' => '',
    ];

    public function testListAllRoles_()
    {
        $this->getTestingAdmin();

        // send the HTTP request
        $response = $this->apiCall($this->endpoint, 'get');

        // assert response status is correct
        $this->assertEquals('200', $response->getStatusCode());

        // convert JSON response string to Object
        $responseObject = $this->getResponseObject($response);

        $this->assertTrue(count($responseObject->data) > 0);
    }

}
