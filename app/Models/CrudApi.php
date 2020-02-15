<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class CrudApi extends Model
{
    /**
     * Rules for validate data insertion
     *
     * @return array
     */
    abstract public function insertRules(): array;

    /**
     * Custom messages for validation fail when inserting data
     *
     * @return array
     */
    abstract public function insertRulesMessages (): array;

    /**
     * Rules for validate data update
     *
     * @param null $id
     * @return array
     */
    abstract public function updateRules($id = null): array;

    /**
     * Custom messages for validation fail when updating data
     *
     * @return array
     */
    abstract public function updateRulesMessages ($id = null): array;
}
