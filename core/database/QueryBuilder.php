<?php

namespace App\Core\Database;

use App\Core\App;
use PDO;
use PDOException;
use PDOStatement;
use App\Core\Logger\LogToFile;

class QueryBuilder
{
    protected $pdo;

    /*
     * This function is the constructor for the QueryBuilder class and simply initializes a new PDO object.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /*
     * This function selects all of the rows from a table in a database.
     */
    public function selectAll(string $table, $limit = "", $offset = "")
    {
        return $this->select($table, "*", $limit, $offset);
    }

    /*
     * This function selects rows from a table in a database where one or more conditions are matched.
     */
    public function selectAllWhere(string $table, $where, $limit = "", $offset = "")
    {
        return $this->selectWhere($table, "*", $where, $limit, $offset);
    }

    /*
     * This function selects rows from a table in a database.
     */
    public function select(string $table, string $columns, $limit = "", $offset = "")
    {
        $limit = $this->prepareLimit($limit);
        $offset = $this->prepareOffset($offset);
        $sql = "SELECT $columns FROM {$table} {$limit} {$offset}";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            $this->handlePDOException($e);
        }
        return false;
    }

    /*
     * This function selects rows from a table in a database where one or more conditions are matched.
     */
    public function selectWhere(string $table, string $columns, $where, $limit = "", $offset = "")
    {
        $limit = $this->prepareLimit($limit);
        $offset = $this->prepareOffset($offset);
        $where = $this->prepareWhere($where);
        $mapped_wheres = $this->prepareMappedWheres($where);
        $where = array_column($where, 3);
        $sql = "SELECT $columns FROM {$table} WHERE $mapped_wheres {$limit} {$offset}";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($where);
            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            $this->handlePDOException($e);
        }
        return false;
    }

    /*
     * This function deletes rows from a table in a database.
     */
    public function delete(string $table, $limit = ""): bool
    {
        $limit = $this->prepareLimit($limit);
        $sql = "DELETE FROM {$table} {$limit}";
        try {
            $statement = $this->pdo->prepare($sql);
            return $statement->execute();
        } catch (PDOException $e) {
            $this->handlePDOException($e);
        }
        return false;
    }


    /*
     * This function deletes rows from a table in a database where one or more conditions are matched.
     */
    public function deleteWhere(string $table, $where, $limit = ""): bool
    {
        $limit = $this->prepareLimit($limit);
        $where = $this->prepareWhere($where);
        $mapped_wheres = $this->prepareMappedWheres($where);
        $where = array_column($where, 3);
        $sql = "DELETE FROM {$table} WHERE $mapped_wheres {$limit}";
        try {
            $statement = $this->pdo->prepare($sql);
            return $statement->execute($where);
        } catch (PDOException $e) {
            $this->handlePDOException($e);
        }
        return false;
    }

    /*
     * This function inserts data into a table in a database.
     */
    public function insert(string $table, $parameters): bool
    {
        $names = $this->prepareCommaSeparatedColumnNames($parameters);
        $values = $this->prepareCommaSeparatedColumnValues($parameters);
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            $names,
            $values
        );
        try {
            $statement = $this->pdo->prepare($sql);
            return $statement->execute($parameters);
        } catch (PDOException $e) {
            $this->handlePDOException($e);
        }
        return false;
    }

    /*
     * This function updates data in a table in a database.
     */
    public function update(string $table, $parameters, $limit = ""): bool
    {
        $limit = $this->prepareLimit($limit);
        $set = $this->prepareNamed($parameters);
        $sql = sprintf(
            'UPDATE %s SET %s %s',
            $table,
            $set,
            $limit
        );
        try {
            $statement = $this->pdo->prepare($sql);
            return $statement->execute($parameters);
        } catch (PDOException $e) {
            $this->handlePDOException($e);
        }
        return false;
    }

    /*
     * This function updates data in a table in a database where one or more conditions are matched.
     */
    public function updateWhere(string $table, $parameters, $where, $limit = ""): bool
    {
        $limit = $this->prepareLimit($limit);
        $set = $this->prepareUnnamed($parameters);
        $parameters = $this->prepareParameters($parameters);
        $where = $this->prepareWhere($where);
        $mapped_wheres = $this->prepareMappedWheres($where);
        $where = array_column($where, 3);
        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s %s',
            $table,
            $set,
            $mapped_wheres,
            $limit
        );
        try {
            $statement = $this->pdo->prepare($sql);
            return $statement->execute(array_merge($parameters, $where));
        } catch (PDOException $e) {
            $this->handlePDOException($e);
        }
        return false;
    }

    /*
     * This function prepares the where clause array for the query builder.
     */
    private function prepareWhere($where)
    {
        $array = $where;
        foreach ($where as $key => $value) {
            if (count($value) < 4) {
                array_unshift($array[$key], 0);
            }
        }
        return $array;
    }

    /*
     * This function prepares the limit statement for the query builder.
     */
    private function prepareLimit($limit)
    {
        return (!empty($limit) ? " LIMIT " . $limit : "");
    }

    /*
     * This function prepares the offset statement for the query builder.
     */
    private function prepareOffset($offset)
    {
        return (!empty($offset) ? " OFFSET " . $offset : "");
    }

    /*
     * This function prepares the comma separated names for the query builder.
     */
    private function prepareCommaSeparatedColumnNames($parameters): string
    {
        return implode(', ', array_keys($parameters));
    }

    /*
     * This function prepares the comma separated values for the query builder.
     */
    private function prepareCommaSeparatedColumnValues($parameters): string
    {
        return ':' . implode(', :', array_keys($parameters));
    }

    /*
     * This function prepares the mapped wheres.
     */
    private function prepareMappedWheres($where): string
    {
        $mapped_wheres = '';
        foreach ($where as $clause) {
            $modifier = $mapped_wheres === '' ? '' : $clause[0];
            $mapped_wheres .= " {$modifier} {$clause[1]} {$clause[2]} ?";
        }
        return $mapped_wheres;
    }

    /*
     * This function prepares the unnamed columns.
     */
    private function prepareUnnamed($parameters): string
    {
        return implode(', ', array_map(
            static function ($property) {
                return "{$property} = ?";
            },
            array_keys($parameters)
        ));
    }

    /*
     * This function prepares the named columns.
     */
    private function prepareNamed($parameters): string
    {
        return implode(', ', array_map(
            static function ($property) {
                return "{$property} = :{$property}";
            },
            array_keys($parameters)
        ));
    }

    /*
     * This function prepares the parameters with numeric keys.
     */
    private function prepareParameters($parameters, $counter = 1)
    {
        foreach ($array = $parameters as $key => $value) {
            unset($parameters[$key]);
            $parameters[$counter] = $value;
            $counter++;
        }
        return $parameters;
    }

    /*
     * This function binds values from an array to the PDOStatement.
     */
    private function prepareBindings(PDOStatement $PDOStatement, $array, $counter = 1): void
    {
        foreach ($array as $key => $value) {
            $PDOStatement->bindParam($counter, $value);
            $counter++;
        }
    }

    /*
     * This function handles PDO exceptions.
     */
    private function handlePDOException(PDOException $e)
    {
        App::logError('There was a PDO Exception. Details: ' . $e);
        if (App::get('config')['options']['debug']) {
            return view('error', ['error' => $e->getMessage()]);
        }
        return view('error');
    }
}

?>