<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class Customer extends CrudApi
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'country_id', 'user_id'
    ];

    /**
     * @return array
     */
    public function insertRules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'phone' => 'required',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    /**
     * @param null $id
     * @return array
     */
    public function updateRules($id = null): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone' => 'required',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    /**
     * @return array
     */
    public function insertRulesMessages(): array
    {
        return [];
    }

    /**
     * @param null $id
     * @return array
     */
    public function updateRulesMessages($id = null): array
    {
        return [];
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $data['user_id'] = Auth::id();
        return parent::create($data);
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return parent::get()->where('user_id', Auth::id());
    }
}
