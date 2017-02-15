<?php

/**
 * @apiGroup           RolePermission
 * @apiName            deleteRole
 * @api                {delete} /roles/:name Delete Role
 * @apiDescription     Delete Role by name
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated Role
 *
 * @apiHeader          Accept application/json
 * @apiHeader          Authorization Bearer {Role-Token}
 *
 * @apiSuccessExample  {json}       Success-Response:
 * HTTP/1.1 202 OK
{
    "message": "Role (manager) Deleted Successfully."
}
 */

$router->delete('roles/{name}', [
    'uses'       => 'Controller@deleteRole',
    'middleware' => [
        'api.auth',
    ],
]);
