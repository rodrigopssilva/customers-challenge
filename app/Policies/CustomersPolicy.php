<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomersPolicy
{
    use HandlesAuthorization;

    /**
     * @var string
     */
    private $message = 'You Shall Not Pass!!!';

    /**
     * Determine whether the user can view any models customers.
     *
     * @param User $user
     */
    public function viewAny(User $user)
    {
        return $this->userHasPermission($user->id > 0);
    }

    /**
     * Determine whether the user can view the models customer.
     *
     * @param User $user
     * @param Customer $customer
     * @return bool
     * @throws AuthorizationException
     */
    public function view(User $user, Customer $customer)
    {
        return $this->userHasPermission($user->id == $customer->user_id);
    }

    /**
     * Determine whether the user can create models customers.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $this->userHasPermission($user->id > 0);
    }

    /**
     * Determine whether the user can update the models customer.
     *
     * @param User $user
     * @param Customer $customer
     * @return bool
     * @throws AuthorizationException
     */
    public function update(User $user, Customer $customer)
    {
        return $this->userHasPermission($user->id == $customer->user_id);
    }

    /**
     * Determine whether the user can delete the models customer.
     *
     * @param User $user
     * @param Customer $customer
     * @return bool
     * @throws AuthorizationException
     */
    public function delete(User $user, Customer $customer)
    {
        return $this->userHasPermission($user->id == $customer->user_id);
    }

    /**
     * Checks if the user has authorization the access.
     *
     * If $id and $userId are identical you should pass.
     * Otherwise You Shall Not Pass!
     *
     * @param bool $shallPass
     * @return true when $id and $userId are identical
     * @throws AuthorizationException when $id and $userId are different
     */
    private function userHasPermission($shallPass)
    {
        if ($shallPass) {
            return true;
        }
        $this->youShallNotPass($this->message);
    }

    /**
     * Throws an AuthorizationException to unauthorize the user.
     *
     * @param null $message
     * @param null $code
     * @throws AuthorizationException
     */
    protected function youShallNotPass($message = null, $code = null)
    {
        throw new AuthorizationException($message, $code);
    }
}
