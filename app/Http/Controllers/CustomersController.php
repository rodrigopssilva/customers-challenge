<?php

namespace App\Http\Controllers;

use App\Models\Customer;

class CustomersController extends CrudApiController
{
    protected $model = Customer::class;
}
