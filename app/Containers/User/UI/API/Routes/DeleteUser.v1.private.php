<?php

/**
 * @apiGroup           Users
 * @apiName            DeleteUser
 * @api                {delete} /users/:id Delete User (admin, client..)
 * @apiDescription     Delete Users of any type (Admin, Client,...)
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiHeader          Accept application/json (required)
 * @apiHeader          Authorization Bearer {User-Token} (required)
 *
 * @apiSuccessExample  {json}       Success-Response:
 * HTTP/1.1 202 OK
{
    "message": "User (4) Deleted Successfully."
}
 */

$router->delete('users/{id}', [
    'uses'       => 'Controller@deleteUser',
    'middleware' => [
        'api.auth',
    ],
]);
