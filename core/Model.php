<?php
/*
 * This is the base model. All other models extend this model.
 */

namespace App\Core;

abstract class Model
{

    protected static $table = '';
    protected $id = 0;
    protected $cols = [];
    protected $array = [];

    public function find($columns): Model
    {
        $this->array = App::get('database')->selectAllWhere(static::$table, $columns);
        return $this;
    }

    public function add($columns): void
    {
        App::get('database')->insert(static::$table, $columns);
    }

    public function update(): void
    {
        App::get('database')->update(static::$table);
    }

    public function updateWhere($parameters, $where): void
    {
        App::get('database')->updateWhere(static::$table, $parameters, $where);
    }

    public function delete(): void
    {
        App::get('database')->delete(static::$table);
    }

    public function deleteWhere($where): void
    {
        App::get('database')->deleteWhere(static::$table, $where);
    }

    public static function all()
    {
        return App::get('database')->selectAll(static::$table);
    }

    public function get(): array
    {
        return $this->array;
    }

    public function first()
    {
        return $this->array[0] ?? null;
    }

    public function firstOrFail()
    {
        return $this->array[0];
    }
}