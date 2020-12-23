<?php
/*
 * This is the base model. All other models extend this model.
 */

namespace App\Core\Database;

use App\Core\App;
use RuntimeException;
use Exception;

/**
 * Class Model
 * @package App\Core\Database
 */
abstract class Model
{

    /**
     * The table name for the Model.
     * @var string
     */
    protected static $table = '';

    /**
     * The ID for the Model.
     * @var int
     */
    protected $id = 0;

    /**
     * The columns for the Model.
     * @var array
     */
    protected $cols = [];

    /**
     * The rows for the Model.
     * @var array
     */
    protected $rows = [];

    /**
     * This method returns the last SQL query by the query builder.
     * @return string
     * @throws Exception
     */
    public function getSql(): string
    {
        return App::get('database')->setClassName(get_class($this))->getSql();
    }

    /**
     * This method finds one or more rows in the database and binds it to the Model, or returns null if no rows are found.
     * @param $where
     * @return $this|null
     * @throws Exception
     */
    public function find($where, $limit = "", $offset = ""): ?Model
    {
        $this->rows = App::get('database')->setClassName(get_class($this))->selectAllWhere(static::$table, $where, $limit, $offset);
        return !empty($this->rows) ? $this : null;
    }

    /**
     * This method finds one or more rows in the database and binds it to the Model, or throws an exception if no rows are found.
     * @param $where
     * @return $this
     * @throws Exception
     */
    public function findOrFail($where, $limit = "", $offset = ""): Model
    {
        $this->rows = App::get('database')->setClassName(get_class($this))->selectAllWhere(static::$table, $where, $limit, $offset);
        if (!empty($this->rows)) {
            return $this;
        }
        throw new RuntimeException("ModelNotFoundException");
    }

    /**
     * This method returns the count of the rows for a database query.
     * @param $where
     * @return int|bool
     * @throws Exception
     */
    public function count($where = "")
    {
        if (!empty($where)) {
            return App::get('database')->setClassName(get_class($this))->countWhere(static::$table, $where);
        }
        return App::get('database')->setClassName(get_class($this))->count(static::$table);
    }

    /**
     * This method adds the row to the database and binds it to the model.
     * @param $columns
     * @return $this
     * @throws Exception
     */
    public function add($columns): Model
    {
        $id = App::get('database')->insert(static::$table, $columns);
        $cols = App::get('database')->setClassName(get_class($this))->describe(static::$table);
        $this->rows = App::get('database')->setClassName(get_class($this))->selectAllWhere(static::$table, [[$cols[0]->Field, '=', $id]]);
        return $this;
    }

    /**
     * This method updates one or more rows in the database.
     * @param $parameters
     * @throws Exception
     */
    public function update($parameters): void
    {
        App::get('database')->update(static::$table, $parameters);
    }

    /**
     * This method updates one or more rows in the database matching specific criteria.
     * @param $parameters
     * @param $where
     * @throws Exception
     */
    public function updateWhere($parameters, $where): void
    {
        App::get('database')->updateWhere(static::$table, $parameters, $where);
    }

    /**
     * This method deletes one or more rows from the database.
     * @throws Exception
     */
    public function delete(): void
    {
        App::get('database')->delete(static::$table);
    }

    /**
     * This method deletes one or more rows from the database matching specific criteria.
     * @param $where
     * @throws Exception
     */
    public function deleteWhere($where): void
    {
        App::get('database')->deleteWhere(static::$table, $where);
    }

    /**
     * This method updates one or more rows in the database.
     * @throws Exception
     */
    public function save(): void
    {
        $cols = App::get('database')->setClassName(get_class($this))->describe(static::$table);
        $newValues = [];
        foreach ($cols as $col) {
            $newValues[$col->Field] = $this->{$col->Field};
        }
        App::get('database')->updateWhere(static::$table, $newValues, [[$cols[0]->Field, '=', $this->{$cols[0]->Field}]]);
    }

    /**
     * This static method returns and binds one or more rows in the database to the model.
     * @return mixed
     * @throws Exception
     */
    public static function all()
    {
        return App::get('database')->setClassName(static::class)->selectAll(static::$table);
    }

    /**
     * This method fetches all of the rows for the Model.
     * @return array
     */
    public function get(): array
    {
        return $this->rows;
    }

    /**
     * This method fetches the first row for the Model.
     * @return mixed|null
     */
    public function first()
    {
        return $this->rows[0] ?? null;
    }

    /**
     * This method fetches the first row for the Model or throws an exception if a row is not found.
     * @return mixed
     */
    public function firstOrFail()
    {
        if (!empty($this->rows[0])) {
            return $this->rows[0];
        }
        throw new RuntimeException("ModelNotFoundException");
    }
}