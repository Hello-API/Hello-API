<?php

namespace Mega\Modules\User\Repositories\Eloquent;

use Mega\Modules\User\Contracts\UserRepositoryInterface;
use Mega\Modules\User\Models\User;
use Mega\Services\Core\Repository\Abstracts\Repository;

/**
 * Class UserRepository.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UserRepository extends Repository implements UserRepositoryInterface
{

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'  => 'like',
        'email' => '=',
    ];

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
}
