<?php

declare(strict_types=1);

namespace JPI;

use PDO;
use PDOException;
use PDOStatement;

/**
 * Simple extension to PDO with some extra convenient methods.
 */
class Database extends PDO {

    /**
     * Prepares a query statement and binds params.
     *
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
     */
    public function run(string $query, array $params = []): PDOStatement {
        $statement = $this->prep($query, $params);
        $statement->execute();
        return $statement;
    }

    /**
     * Executes a SQL query with optional params/bindings and returns effected rows count.
     */
    public function exec($query, array $params = []): int {
        return $this->run($query, $params)->rowCount();
    }

    /**
     * Execute a SELECT query and returns all the rows.
     *
     * @return array[]
     * @throws PDOException
     */
    public function selectAll(string $query, array $params = []): array {
        return $this->run($query, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Execute a SELECT query and returns the first row (if found).
     *
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
     */
    public function getLastInsertedId(): ?int {
        return $this->lastInsertId() ? ((int)$this->lastInsertId()) : null;
    }
}
