<?php

namespace JPI\Database;

use PDO;
use PDOStatement;

/**
 * Simple extension to PDO with some extra convenient methods.
 *
 * @author Jahidul Pabel Islam <me@jahidulpabelislam.com>
 * @copyright 2012-2022 JPI
 */
class Connection extends PDO {

    /**
     * Executes a SQL query.
     *
     * @param string $query The SQL query to run
     * @param array|null $params Array of any params/bindings to use with the SQL query
     * @return \PDOStatement
     * @throws \PDOException
     */
    protected function run(string $query, ?array $params = null): PDOStatement {
        if (!isset($params)) {
            return $this->query($query);
        }

        $bindings = [];
        foreach ($params as $key => $value) {
            $bindings[":$key"] = $value;
        }

        $stmt = $this->prepare($query);
        $stmt->execute($bindings);
        return $stmt;
    }

    /**
     * Executes a SQL query and returns the count of rows affected.
     *
     * (Used by INSERT, UPDATE & DELETE queries)
     *
     * @param string $query
     * @param array|null $params
     * @return int
     * @throws \PDOException
     */
    public function execute(string $query, ?array $params = null): int {
        return $this->run($query, $params)->rowCount();
    }

    /**
     * Execute a SELECT query and returns the first row (if found).
     *
     * @param string $query
     * @param array|null $params
     * @return array|null
     * @throws \PDOException
     */
    public function getOne(string $query, ?array $params = null): ?array {
        $row = $this->run($query, $params)->fetch(PDO::FETCH_ASSOC);
        if ($row !== false) {
            return $row;
        }

        return null;
    }

    /**
     * Execute a SELECT query and returns all the rows.
     *
     * @param string $query
     * @param array|null $params
     * @return array[]
     * @throws \PDOException
     */
    public function getAll(string $query, ?array $params = null): array {
        return $this->run($query, $params)->fetchAll(PDO::FETCH_ASSOC);
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
