<?php


namespace Tests\Feature\Http\Resources;


use App\Http\Resources\CustomersResource;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

//class CustomersResourceTest extends TestCase
//{

//    use RefreshDatabase;

//    public function testToArrayStructure()
//    {
//        $user = factory(User::class)->create();
//        $customer = factory(Customer::class)->create();
//        $collection = CustomersResource::collection($customers);
//
//        $this->assertCount(2, $collection);
//    }
//}
