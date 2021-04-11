<?php

namespace App\Containers\AppSection\Authorization\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\RevokeUserFromRoleRequest;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class RevokeUserFromRoleAction extends Action
{
    public function run(RevokeUserFromRoleRequest $data): User
    {
        $user = null;

        // if user ID is passed then convert it to instance of User (could be user Id Or Model)
        if (!$data->user_id instanceof User) {
            $user = Apiato::call(FindUserByIdTask::class, [$data->user_id]);
        }

        // convert to array in case single ID was passed (could be Single Or Multiple Role Ids)
        $rolesIds = (array)$data->roles_ids;

        $roles = new Collection();

        foreach ($rolesIds as $roleId) {
            $role = Apiato::call(FindRoleTask::class, [$roleId]);
            $roles->add($role);
        }

        foreach ($roles->pluck('name')->toArray() as $roleName) {
            $user->removeRole($roleName);
        }

        return $user;
    }
}
