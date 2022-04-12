# EngWords
Simple PHP console-app for learning english words

## Features

-   Creating own words
-   Removing words from database
-   Quiz with random words

## Requirements

| Name                                                        | Version |
| ----------------------------------------------------------- | ------- |
| [PHP](https://respect-validation.readthedocs.io/en/latest/) | ^8.1    |
| [MySQL](https://www.mysql.com/)                             | ^8.0    |

## Packages

| Name                                                                       | Version |
| -------------------------------------------------------------------------- | ------- |
| [respect/validation](https://respect-validation.readthedocs.io/en/latest/) | 2.2     |
| [phpunit/phpunit](https://phpunit.de/)                                     | 9.5     |
| [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)                    | 5.4     |

## Run Locally

Clone the project

```bash
  git clone https://github.com/CubeStorm/eng-words
```

Go to the project directory

```bash
  cd eng-words
```

Install dependencies

```bash
  composer install
```

Create .env file

Copy .env.example content and paste to .env file

Use there your own database settings

Create database in mysql named "engwords'

Run app

```bash
  php index.php
```

## Running Tests

To run tests, run the following command

```bash
  php vendor/bin/phpunit tests
```

## Todo

-   Divide words to own categories
