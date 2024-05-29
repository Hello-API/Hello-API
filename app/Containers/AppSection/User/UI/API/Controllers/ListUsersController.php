<?php

namespace App\Containers\AppSection\User\UI\API\Controllers;

use App\Containers\AppSection\User\Actions\ListUsersAction;
use App\Containers\AppSection\User\UI\API\Requests\ListUsersRequest;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Spatie\Fractal\Facades\Fractal;

class ListUsersController extends ApiController
{
    public function __invoke(ListUsersRequest $request, ListUsersAction $action): array|null
    {
        $users = $action->run();

        return Fractal::create($users, UserTransformer::class)->toArray();
    }
}
