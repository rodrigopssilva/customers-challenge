<?php


namespace Tests\Feature\Policies;


use App\Models\Country;
use App\Models\Customer;
use App\Policies\CustomersPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CustomersPolicyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers App\Policies\CustomersPolicy::create
     * @covers App\Policies\CustomersPolicy::viewAny
     * @covers App\Policies\CustomersPolicy::userHasPermission
     * @covers App\Policies\CustomersPolicy::view
     * @covers App\Policies\CustomersPolicy::update
     * @covers App\Policies\CustomersPolicy::delete
     */
    public function testPoliciesWithAuthenticatedUserShouldReturnTrue()
    {
        $country = factory(Country::class)->create();
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->make(
            [
                'user_id' => $user->id,
                'country_id' => $country->id,
            ]
        );

        $object = new CustomersPolicy();
        $this->assertTrue($object->create($user));
        $this->assertTrue($object->viewAny($user));

        $this->assertTrue($object->view($user, $customer));
        $this->assertTrue($object->update($user, $customer));
        $this->assertTrue($object->delete($user, $customer));
    }

    /**
     * @covers App\Policies\CustomersPolicy::create
     * @covers App\Policies\CustomersPolicy::viewAny
     * @covers App\Policies\CustomersPolicy::userHasPermission
     * @covers App\Policies\CustomersPolicy::view
     * @covers App\Policies\CustomersPolicy::update
     * @covers App\Policies\CustomersPolicy::delete
     * @covers App\Policies\CustomersPolicy::youShallNotPass
     */
    public function testPoliciesWithUnauthenticatedUserShouldThrowAuthorizationException()
    {
        $country = factory(Country::class)->create();
        $userAuthorized = factory(User::class)->create();
        $customer = factory(Customer::class)->make(
            [
                'user_id' => $userAuthorized->id,
                'country_id' => $country->id,
            ]
        );

        $this->expectException(AuthorizationException::class);
        $this->expectErrorMessage('You Shall Not Pass!!!');

        $user = new User();
        $object = new CustomersPolicy();
        $this->assertTrue($object->create($user));
        $this->assertTrue($object->viewAny($user));

        $this->assertTrue($object->view($user, $customer));
        $this->assertTrue($object->update($user, $customer));
        $this->assertTrue($object->delete($user, $customer));
    }
}
