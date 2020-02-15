<?php


namespace Tests\Feature\Models;

use App\Models\Country;
use App\Models\Customer;
use App\Models\User;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    private $customerModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customerModel = new Customer();
    }

    /**
     * @covers \App\Models\Customer::get
     */
    public function testGetCustomersOfAuthenticatedUser()
    {
        $country = factory(Country::class)->create();
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create(
            [
                'user_id' => $user->id,
                'country_id' => $country->id,
            ]
        );
        $this->actingAs($user);
        $actual = $this->customerModel->get();

        $this->assertEquals([$customer->toArray()], $actual->toArray());
    }

    /**
     * @covers \App\Models\Customer::create
     */
    public function testCreateCustomerOfTheAuthenticatedUser()
    {
        $country = factory(Country::class)->create();
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create(
            [
                'user_id' => $user->id,
                'country_id' => $country->id,
            ]
        );
        $this->actingAs($user);

        $customerData = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '+123456789',
            'country_id' => $country->id,
        ];

        $actual = $this->customerModel->create($customerData)->toArray();

        $this->assertEquals($user->id, $actual['user_id']);
    }

    /**
     * @dataProvider emptyArrayMethods
     * @covers       \App\Models\Customer::insertRulesMessages
     * @covers       \App\Models\Customer::updateRulesMessages
     * @param $methodName
     */
    public function testMethodsReturnsEmptyArray($methodName)
    {
        $actual = $this->customerModel->$methodName();
        $expected = [];
        $this->assertEquals($expected, $actual);
    }

    public function emptyArrayMethods()
    {
        return [
            ['insertRulesMessages'],
            ['updateRulesMessages'],
        ];
    }

    /**
     * @dataProvider notEmptyArrayMethods
     * @covers       \App\Models\Customer::insertRules
     * @covers       \App\Models\Customer::updateRules
     * @param $methodName
     */
    public function testMethodsReturnsArrayHasSameStructure($methodName)
    {
        $actual = array_keys($this->customerModel->$methodName());
        $expected =  [
            'name',
            'email',
            'phone',
            'country_id',
        ];
        $this->assertEquals($expected, $actual);
    }

    public function notEmptyArrayMethods()
    {
        return [
            ['insertRules'],
            ['updateRules'],
        ];
    }
}
