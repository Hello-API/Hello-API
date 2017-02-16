<?php

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\RoleRepository;
use App\Port\Action\Abstracts\Action;

/**
 * Class DeleteRoleTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteRoleTask extends Action
{

    /**
     * @var  \App\Containers\Authorization\Data\Repositories\RoleRepository
     */
    private $roleRepository;

    /**
     * DeleteRoleTask constructor.
     *
     * @param \App\Containers\Authorization\Data\Repositories\RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param $roleName
     *
     * @return bool
     */
    public function run($roleName)
    {
        // delete the record from the roles table.
        $this->roleRepository->delete($this->roleRepository->findWhere(['name' => $roleName])->first()->id);

        return true;
    }
}
