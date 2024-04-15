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

Extra Methods:
- `prep`: when you want to bind some parameters to a query, returns `PDOStatement`
- `run`: when you bind some parameters to a query and want to execute it, returns `PDOStatement`
- `selectAll`: for a `SELECT` query, returns a multidimensional array of all the rows found
- `selectFirst`: for a `SELECT` query that has `LIMIT 1`, returns an associative array of the first row found (if any)
- `getLastInsertedId`: helpful after a `INSERT` query, returns the ID of the newly inserted row

Overridden Methods:
- `exec`: for `INSERT`, `UPDATE` and `DELETE` queries, returns the number of rows affected

All methods except `getLastInsertedId` take the query as the first parameter (required), and an array of params to bind to the query (optional).

### Examples:

(Assuming instance has been created and set to a variable named `$connection`)

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

## Changelog

See [CHANGELOG](CHANGELOG.md)

## Support

If you found this library interesting or useful please do spread the word of this library: share on your social's, star on GitHub, etc.

If you find any issues or have any feature requests, you can open a [issue](https://github.com/jahidulpabelislam/database/issues) or can email [me @ jahidulpabelislam.com](mailto:me@jahidulpabelislam.com) :smirk:.

## Authors

-   [Jahidul Pabel Islam](https://jahidulpabelislam.com/) [<me@jahidulpabelislam.com>](mailto:me@jahidulpabelislam.com)

## License

This module is licensed under the General Public License - see the [License](LICENSE.md) file for details
