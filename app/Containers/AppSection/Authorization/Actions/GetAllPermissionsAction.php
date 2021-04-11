<?php

namespace App\Containers\AppSection\Authorization\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\AppSection\Authorization\Tasks\GetAllPermissionsTask;
use App\Ship\Parents\Actions\Action;

class GetAllPermissionsAction extends Action
{
    public function run()
    {
        return Apiato::call(GetAllPermissionsTask::class);
    }
}
