# Database

[![CodeFactor](https://www.codefactor.io/repository/github/jahidulpabelislam/database/badge)](https://www.codefactor.io/repository/github/jahidulpabelislam/database)
[![Latest Stable Version](https://poser.pugx.org/jpi/database/v/stable)](https://packagist.org/packages/jpi/database)
[![Total Downloads](https://poser.pugx.org/jpi/database/downloads)](https://packagist.org/packages/jpi/database)
[![Latest Unstable Version](https://poser.pugx.org/jpi/database/v/unstable)](https://packagist.org/packages/jpi/database)
[![License](https://poser.pugx.org/jpi/database/license)](https://packagist.org/packages/jpi/database)
![GitHub last commit (branch)](https://img.shields.io/github/last-commit/jahidulpabelislam/database/2.x.svg?label=last%20activity)

Simple extension to PDO with some extra convenient methods.

## Installation

Use [Composer](https://getcomposer.org/)

```bash
$ composer require jpi/database 
```

## Usage

### Initialisation

First, create an instance of the Database class by providing PDO connection parameters:

```php
$connection = new \JPI\Database(
    "mysql:host=localhost;dbname=your_database",
    "username",
    "password"
);
```

### Available Methods

Extra Methods:

- `prep(string, array): PDOStatement`: when you want to bind some parameters to a query
- `run(string, array): PDOStatement`: when you bind some parameters to a query and want to execute it
- `selectAll(string, array): array`: for a `SELECT` query, returns a multidimensional array of all the rows found
- `selectFirst(string, array): array|null`: for a `SELECT` query that has `LIMIT 1`, returns an associative array of the first row found (if any)
- `getLastInsertedId(): int|null`: helpful after an `INSERT` query, returns the ID of the newly inserted row

Overridden Methods:

- `exec(string, array): int`: for `INSERT`, `UPDATE` and `DELETE` queries, returns the number of rows affected

All methods except `getLastInsertedId` take the query as the first parameter (required), and an array of params to bind to the query (optional).

### Examples:

(Assuming instance has been created and set to a variable named `$connection`)

#### prep:

```php
// Prepare a statement with bound parameters (without executing)
$statement = $connection->prep(
    "SELECT * FROM users WHERE email = :email;",
    ["email" => "jahidul@jahidulpabelislam.com"]
);

// You can now execute it later
$statement->execute();
```

#### run:

```php
// Prepare and execute a query in one step
$statement = $connection->run(
    "SELECT * FROM users WHERE email = :email;",
    ["email" => "jahidul@jahidulpabelislam.com"]
);

// Fetch results from the statement
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
```

#### selectAll:

```php
$rows = $connection->selectAll("SELECT * FROM users;");

/**
$rows = [
    [
        "id" => 1,
        "first_name" => "Jahidul",
        "last_name" => "Islam",
        "email" => "jahidul@jahidulpabelislam.com",
        "password" => "password123",
        ...
    ],
    [
        "id" => 2,
        "first_name" => "Test",
        "last_name" => "Example",
        "email" => "test@example.com",
        "password" => "password123",
        ...
    ],
    ...
];
*/
```

#### selectFirst:

```php
$row = $connection->selectFirst("SELECT * FROM users LIMIT 1;");

/**
$row = [
    "id" => 1,
    "first_name" => "Jahidul",
    "last_name" => "Islam",
    "email" => "jahidul@jahidulpabelislam.com",
    "password" => "password",
    ...
];
*/
```

#### exec:

```php
// INSERT
$numberOfRowsAffected = $connection->exec(
    "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password);",
    [
        "first_name" => "Jahidul",
        "last_name" => "Islam",
        "email" => "jahidul@jahidulpabelislam.com",
        "password" => "password",
    ]
);

// UPDATE
$numberOfRowsAffected = $connection->exec(
    "UPDATE users SET first_name = :first_name WHERE id = :id;",
    [
        "id" => 1,
        "first_name" => "Pabel",
    ]
);

// DELETE
$numberOfRowsAffected = $connection->exec("DELETE FROM users WHERE id = :id;", ["id" => 1]);
```

#### getLastInsertedId:

```php
// INSERT a new user
$connection->exec(
    "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password);",
    [
        "first_name" => "Jahidul",
        "last_name" => "Islam",
        "email" => "jahidul@jahidulpabelislam.com",
        "password" => "password",
    ]
);

// Get the ID of the newly inserted row
$newRowId = $connection->getLastInsertedId();
// $newUserId = 3
```

## Support

If you found this library interesting or useful please spread the word about this library: share on your socials, star on GitHub, etc.

If you find any issues or have any feature requests, you can open a [issue](https://github.com/jahidulpabelislam/database/issues) or email [me @ jahidulpabelislam.com](mailto:me@jahidulpabelislam.com) :smirk:.

## Authors

- [Jahidul Pabel Islam](https://jahidulpabelislam.com/) [<me@jahidulpabelislam.com>](mailto:me@jahidulpabelislam.com)

## Licence

This module is licensed under the General Public Licence - see the [licence](LICENSE.md) file for details.
