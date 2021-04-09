<?php

namespace App\Containers\AppSection\User\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\UI\API\Requests\CreateAdminRequest;
use App\Ship\Parents\Actions\Action;

class CreateAdminAction extends Action
{
    public function run(CreateAdminRequest $data): User
    {
        $admin = Apiato::call('User@CreateUserByCredentialsTask', [
            true,
            $data->email,
            $data->password,
            $data->name
        ]);

        // NOTE: if not using a single general role for all Admins, comment out that line below. And assign Roles
        // to your users manually. (To list admins in your dashboard look for users with `is_admin=true`).
        Apiato::call('Authorization@AssignUserToRoleTask', [$admin, ['admin']]);

        return $admin;
    }
}