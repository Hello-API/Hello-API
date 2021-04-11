<?php

namespace App\Containers\AppSection\Authorization\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tasks\CreatePermissionTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class CreatePermissionAction extends Action
{
    public function run(Request $data): Permission
    {
        return Apiato::call(CreatePermissionTask::class,
            [$data->name, $data->description, $data->display_name]
        );
    }
}
