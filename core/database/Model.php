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
    
    protected $Field;
    
    protected $Type;
    
    protected $Null;
    
    protected $Key;
    
    protected $Default;
    
    protected $Extra;

    /**
     * This method returns the last SQL query by the query builder.
     * @return string
     * @throws Exception
     */
    public function getSql(): string
    {
        return App::DB()->setClassName(get_class($this))->getSql();
    }

     /**
     * This method finds one or more rows in the database based off of ID and binds it to the Model, or returns null if no rows are found.
     * @param $id
     * @return $this
     * @throws Exception
     */
    public function find($id): ?Model
    {
        $this->cols = App::DB()->setClassName(get_class($this))->describe(static::$table);
        $this->rows = App::DB()->setClassName(get_class($this))->selectAllWhere(static::$table, [[$this->cols[0]->Field, '=', $id]]);
        return !empty($this->rows) ? $this : null;
    }

    /**
     * This method finds one or more rows in the database based off of ID and binds it to the Model, or throws an exception if no rows are found.
     * @param $id
     * @return $this
     * @throws Exception
     */
    public function findOrFail($id): Model
    {
        $this->cols = App::DB()->setClassName(get_class($this))->describe(static::$table);
        $this->rows = App::DB()->setClassName(get_class($this))->selectAllWhere(static::$table, [[$this->cols[0]->Field, '=', $id]]);
        if (!empty($this->rows)) {
            return $this;
        }
        throw new RuntimeException("ModelNotFoundException");
    }

     /**
     * This method finds one or more rows matching specific criteria in the database and binds it to the Model, then returns the Model.
     * @param $where
     * @return $this
     * @throws Exception
     */
    public function where($where, $limit = "", $offset = ""): Model
    {
        $this->cols = App::DB()->setClassName(get_class($this))->describe(static::$table);
        $this->rows = App::DB()->setClassName(get_class($this))->selectAllWhere(static::$table, $where, $limit, $offset);
        return $this;
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
            return App::DB()->setClassName(get_class($this))->countWhere(static::$table, $where);
        }
        return App::DB()->setClassName(get_class($this))->count(static::$table);
    }

    /**
     * This method adds the row to the database and binds it to the model.
     * @param $columns
     * @return $this
     * @throws Exception
     */
    public function add($columns): Model
    {
        $this->id = App::DB()->insert(static::$table, $columns);
        $this->cols = App::DB()->setClassName(get_class($this))->describe(static::$table);
        $this->rows = App::DB()->setClassName(get_class($this))->selectAllWhere(static::$table, [[$this->cols[0]->Field, '=', $this->id]]);
        return $this;
    }

    /**
     * This method updates one or more rows in the database.
     * @param $parameters
     * @return int
     * @throws Exception
     */
    public function update($parameters): int
    {
        return App::DB()->update(static::$table, $parameters);
    }

    /**
     * This method updates one or more rows in the database matching specific criteria.
     * @param $parameters
     * @param $where
     * @return int
     * @throws Exception
     */
    public function updateWhere($parameters, $where): int
    {
        return App::DB()->updateWhere(static::$table, $parameters, $where);
    }

    /**
     * This method deletes one or more rows from the database.
     * @return int
     * @throws Exception
     */
    public function delete(): int
    {
        return App::DB()->delete(static::$table);
    }

    /**
     * This method deletes one or more rows from the database matching specific criteria.
     * @param $where
     * @return int
     * @throws Exception
     */
    public function deleteWhere($where): int
    {
        return App::DB()->deleteWhere(static::$table, $where);
    }

    /**
     * This method updates one or more rows in the database.
     * @return $this
     * @throws Exception
     */
    public function save(): Model
    {
        $this->cols = App::DB()->setClassName(get_class($this))->describe(static::$table);
        $newValues = [];
        foreach ($this->cols as $col) {
            $newValues[$col->Field] = $this->{$col->Field};
        }
        App::DB()->updateWhere(static::$table, $newValues, [[$this->cols[0]->Field, '=', $this->{$this->cols[0]->Field}]]);
        return $this;
    }

    /**
     * This static method returns and binds one or more rows in the database to the model.
     * @return Model[]|false
     * @throws Exception
     */
    public static function all()
    {
        return App::DB()->setClassName(static::class)->selectAll(static::$table);
    }

    /**
     * This method fetches all of the rows for the Model.
     * @return Model[]
     */
    public function get(): array
    {
        return $this->rows;
    }

    /**
     * This method fetches all of the columns for the Model.
     * This returns the columns if they're cached, otherwise they are fetched again first.
     * @return array
     */
    public function describe(): array
    {
        if (!$this->cols) {
           $this->cols = App::DB()->setClassName(get_class($this))->describe(static::$table);
        }
        return $this->cols;
    }

    /**
     * This method fetches the first row for the Model.
     * @return Model|null
     */
    public function first(): ?Model
    {
        return $this->rows[0] ?? null;
    }

    /**
     * This method fetches the first row for the Model or throws an exception if a row is not found.
     * @return Model
     * @throws Exception
     */
    public function firstOrFail(): Model
    {
        if (!empty($this->rows[0])) {
            return $this->rows[0];
        }
        throw new RuntimeException("ModelNotFoundException");
    }

    /**
     * This method returns the primary key's value for the Model, or null if it doesn't have one.
     * @return string|null
     * @throws Exception
     */
    public function id(): ?string
    {
        if (!$this->cols) {
           $this->cols = App::DB()->setClassName(get_class($this))->describe(static::$table);
        }
        return $this->{$this->cols[0]->Field} ?? null;
    }

    /**
     * This method returns the primary key's name for the Model, or null if it doesn't have one.
     * @return string|null
     * @throws Exception
     */
    public function primary(): ?string
    {
        if (!$this->cols) {
           $this->cols = App::DB()->setClassName(get_class($this))->describe(static::$table);
        }
        return $this->cols[0]->Field ?? null;
    }
}