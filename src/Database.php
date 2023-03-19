<?php

declare(strict_types=1);

namespace JPI;

use PDO;
use PDOException;
use PDOStatement;

/**
 * Simple extension to PDO with some extra convenient methods.
 *
 * @author Jahidul Pabel Islam <me@jahidulpabelislam.com>
 * @copyright 2012-2022 JPI
 */
class Database extends PDO {

    /**
     * Prepares a query statement and binds params.
     *
     * @param string $query The SQL query to prepare
     * @param array $params Array of any params/bindings to use with the SQL query
     * @return PDOStatement
     * @throws PDOException
     */
    public function prep(string $query, array $params = []): PDOStatement {
        $statement = $this->prepare($query);

        foreach ($params as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        return $statement;
    }

    /**
     * Executes a SQL query with optional params/bindings and returns statement object.
     *
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function run(string $query, array $params = []): PDOStatement {
        $statement = $this->prep($query, $params);
        $statement->execute();
        return $statement;
    }

    /**
     * Executes a SQL query with optional params/bindings and returns effected rows count.
     *
     * @param string $query
     * @param array $params
     * @return int
     * @throws PDOException
     */
    public function exec($query, array $params = []): int {
        return $this->run($query, $params)->rowCount();
    }

    /**
     * Execute a SELECT query and returns all the rows.
     *
     * @param string $query
     * @param array $params
     * @return array[]
     * @throws PDOException
     */
    public function selectAll(string $query, array $params = []): array {
        return $this->run($query, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Execute a SELECT query and returns the first row (if found).
     *
     * @param string $query
     * @param array $params
     * @return array|null
     * @throws PDOException
     */
    public function selectFirst(string $query, array $params = []): ?array {
        $row = $this->run($query, $params)->fetch(PDO::FETCH_ASSOC);
        if ($row !== false) {
            return $row;
        }

        return null;
    }

    /**
     * Get the ID from the last INSERT query.
     *
     * @return int|null
     */
    public function getLastInsertedId(): ?int {
        return $this->lastInsertId();
    }
}
