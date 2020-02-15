<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use App\Models\Customer;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    private $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    /**
     * @covers App\Http\Controllers\CrudApiController::store
     */
    public function testCanCreateCustomer()
    {
        $country = factory(Country::class)->create();
        $user = factory(User::class)->create();
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->e164PhoneNumber,
            'user_id' => User::all()->random()->id,
            'country_id' => Country::all()->random()->id,
        ];

        $response = $this->actingAs($user)->json('POST', '/api/customer', $data);
        $response
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * @covers App\Http\Controllers\CrudApiController::update
     */
    public function testCanUpdateCustomer()
    {
        $country = factory(Country::class)->create();
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create(
            [
                'user_id' => $user->id,
                'country_id' => $country->id,
            ]
        );
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->e164PhoneNumber,
            'user_id' => $user->id,
            'country_id' => Country::all()->random()->id,
        ];

        $response = $this->actingAs($user)->json('PUT', '/api/customer/' . $customer->id, $data);
        $response
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * @covers App\Http\Controllers\CrudApiController::index
     */
    public function testCanListCustomer()
    {
        $country = factory(Country::class)->create();
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create(
            [
                'user_id' => $user->id,
                'country_id' => $country->id,
            ]
        );

        $response = $this->actingAs($user)->json('GET', '/api/customer');
        $response
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * @covers App\Http\Controllers\CrudApiController::show
     */
    public function testCanViewCustomer()
    {
        $country = factory(Country::class)->create();
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create(
            [
                'user_id' => $user->id,
                'country_id' => $country->id,
            ]
        );

        $response = $this->actingAs($user)->json('GET', '/api/customer/' . $customer->id);
        $response
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * @covers App\Http\Controllers\CrudApiController::destroy
     */
    public function testCanDeleteCustomer()
    {
        $country = factory(Country::class)->create();
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create(
            [
                'user_id' => $user->id,
                'country_id' => $country->id,
            ]
        );

        $response = $this->actingAs($user)->delete('/api/customer/' . $customer->id);
        $response
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * @dataProvider httpMethodAndRouteForNotFound
     * @covers       App\Http\Controllers\CrudApiController::show
     * @covers       App\Http\Controllers\CrudApiController::update
     * @covers       App\Http\Controllers\CrudApiController::destroy
     * @param $httpMethod
     * @param $route
     */
    public function testRoutesMustReturnNotFoundWhenDataIsNotFound($httpMethod, $route)
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->json($httpMethod, $route);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function httpMethodAndRouteForNotFound()
    {
        return [
            ['GET', '/api/customer/' . rand(1, 50)],
            ['PUT', '/api/customer/' . rand(1, 50)],
            ['DELETE', '/api/customer/'  . rand(1, 50)],
        ];
    }
}
