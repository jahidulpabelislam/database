# Database

[![CodeFactor](https://www.codefactor.io/repository/github/jahidulpabelislam/database/badge)](https://www.codefactor.io/repository/github/jahidulpabelislam/database)
[![Latest Stable Version](https://poser.pugx.org/jpi/database/v/stable)](https://packagist.org/packages/jpi/database)
[![Total Downloads](https://poser.pugx.org/jpi/database/downloads)](https://packagist.org/packages/jpi/database)
[![Latest Unstable Version](https://poser.pugx.org/jpi/database/v/unstable)](https://packagist.org/packages/jpi/database)
[![License](https://poser.pugx.org/jpi/database/license)](https://packagist.org/packages/jpi/database)
![GitHub last commit (branch)](https://img.shields.io/github/last-commit/jahidulpabelislam/database/master.svg?label=last%20activity)

Simple library to make interactions with a database easier.

## Installation

Use [Composer](https://getcomposer.org/)

```bash
$ composer require jpi/database 
```

## Usage

Create a instance
```php
$connection = new Connection([
    "host" => "127.0.0.1",
    "database" => "test",
    "username" => "root",
    "password" => "root",
]);
```

Available Methods:
- `getAll`: to use for a `SELECT` query which will return a multidimensional array of all the rows found
- `getOne`: to use for a `SELECT` query which will return an associative array of the first row found (if any)
- `execute`: to use for `INSERT`, `UPDATE` and `DELETE` queries, which will return the number of rows affected
- `getLastInsertedId`: to use after a `INSERT` query, which returns the ID of the newly inserted row

`getAll`, `getOne` & `execute` take the query as the first parameter (required), and an array of params to bind to the query (optional)

### Examples:

(Assuming connection has been created and set to a variable named `$connection`)

#### getAll:

```php
$rows = $connection->getAll("SELECT * FROM users;");

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

#### getOne:

```php
$row = $connection->getOne("SELECT * FROM users LIMIT 1;");

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

#### execute:

```php
// INSERT
$numberOfRowsAffected = $connection->execute(
    "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password);",
    [
        "first_name" => "Jahidul",
        "last_name" => "Islam",
        "email" => "jahidul@jahidulpabelislam.com",
        "password" => "password",
    ]
);

// UPDATE
$numberOfRowsAffected = $connection->execute(
    "UPDATE users SET first_name = :first_name WHERE id = :id;",
    [
        "id" => 1,
        "first_name" => "Pabel",
    ]
);

// DELETE
$numberOfRowsAffected = $connection->execute("DELETE FROM users WHERE id = :id;", ["id" => 1]);
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
