<?php
namespace App\Core\Database;

use PDO;
class QueryBuilder
{
    protected $pdo;
    /*
     * This function is the constructor for the QueryBuilder class and simply creates a new PDO object.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    /*
     * This function selects all of the rows from a table in a database.
     */
    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }
    /*
     * This function inserts data into a table in a database.
     */
    public function insert($table, $parameters)
    {

        $sql = sprintf(

            'insert into %s (%s) values (%s)',

            $table,

            implode(', ', array_keys($parameters)),

            ':' . implode(', :', array_keys($parameters))

            );

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (Exception $e) {

            die('Something went wrong');

        }
    }
}

?>
