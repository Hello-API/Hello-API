<?php

namespace App\Containers\AppSection\Authentication\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Authentication\Notifications\Welcome;
use App\Containers\AppSection\Authentication\Tasks\CreateUserByCredentialsTask;
use App\Containers\AppSection\Authentication\Tasks\SendVerificationEmailTask;
use App\Containers\AppSection\Authentication\UI\API\Requests\RegisterUserRequest;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class RegisterUserAction extends ParentAction
{
    public function __construct(
        protected readonly CreateUserByCredentialsTask $createUserByCredentialsTask,
        protected readonly SendVerificationEmailTask   $sendVerificationEmailTask,
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(RegisterUserRequest $request): User
    {
        $sanitizedData = $request->sanitizeInput([
            'email',
            'password',
            'name',
            'gender',
            'birth',
        ]);

        $user = $this->createUserByCredentialsTask->run($sanitizedData);

        $user->notify(new Welcome());
        $this->sendVerificationEmailTask->run($user, $request->verification_url);

        return $user;
    }
}
