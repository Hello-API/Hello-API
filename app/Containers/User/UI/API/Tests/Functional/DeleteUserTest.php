<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\User\Models\User;
use App\Containers\User\Tests\TestCase;

/**
 * Class DeleteUserTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteUserTest extends TestCase
{

    protected $endpoint = 'delete@users/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'delete-users',
    ];

    public function testDeleteExistingUser_()
    {
        $user = $this->getTestingUser();

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall();

        // assert response status is correct
        $this->assertEquals('202', $response->getStatusCode());

        // assert the returned message is correct
        $this->assertResponseContainKeyValue([
            'message' => 'User (' . $user->getHashedKey() . ') Deleted Successfully.',
        ], $response);
    }

    public function testDeleteAnotherExistingUser_()
    {
        // make the call form the user token who has no access
        $this->getTestingUserWithoutAccess();

        $anotherUser = factory(User::class)->create();

        // send the HTTP request
        $response = $this->injectId($anotherUser->id)->makeCall();

        // assert response status is correct
        $this->assertEquals('500', $response->getStatusCode());
    }
}
