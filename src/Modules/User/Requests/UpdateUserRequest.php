<?php

namespace Mega\Modules\User\Requests;

use Illuminate\Contracts\Auth\Access\Gate;
use Mega\Modules\User\Models\User;
use Mega\Services\Core\Request\Abstracts\Request;

/**
 * Class UpdateUserRequest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateUserRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'min:6|max:30',
            'name'     => 'min:2|max:50',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return bool
     */
    public function authorize(Gate $gate)
    {
        // $this->user(): is the current logged in user, taken from the request
        // $this->id: is the request input user ID (for the user that needs to be updated)
        return $gate->getPolicyFor(User::class)->update($this->user(), $this->id);
    }
}
