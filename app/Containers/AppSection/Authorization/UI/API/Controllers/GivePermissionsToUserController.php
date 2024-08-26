<?php

namespace App\Containers\AppSection\Authorization\UI\API\Controllers;

use Apiato\Core\Facades\Response;
use App\Containers\AppSection\Authorization\Actions\GivePermissionsToUserAction;
use App\Containers\AppSection\Authorization\UI\API\Requests\GivePermissionsToUserRequest;
use App\Containers\AppSection\User\UI\API\Transformers\UserAdminTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Spatie\Fractal\Facades\Fractal;

class GivePermissionsToUserController extends ApiController
{
    public function __invoke(GivePermissionsToUserRequest $request, GivePermissionsToUserAction $action): array|null
    {
        $user = $action->run($request);

        return Fractal::create($user, UserAdminTransformer::class)
            ->parseIncludes(['permissions'])
            ->toArray();
    }
}
