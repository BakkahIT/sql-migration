# SqlMigration Package

`SqlMigration` is a Laravel package designed for executing custom SQL migrations seamlessly within your Laravel application. This package bridges the gap between Laravel's migrations and raw SQL execution, allowing you to write powerful SQL commands directly in your migration files.

## Why Use SqlMigration?

When working with complex database operations, Laravel's schema builder may not suffice. `SqlMigration` empowers developers to:
- Run raw SQL queries directly in migration files.
- Handle advanced database operations that require custom SQL commands.
- Integrate these capabilities seamlessly into Laravel's migration system.

## Features

- **SQL Command Support**: Write `INSERT`, `UPDATE`, `DELETE`, `CREATE TABLE`, and other SQL queries.
- **Laravel Integration**: Fully compatible with Laravel's migration commands.
- **Custom SQL Logic**: Define any SQL query your application needs.
- **Private Use**: Built for internal projects and teams.

## Installation

Install the package in your Laravel project with:

```bash
composer require bakkahit/sql-migration
```

Open the `config/app.php` file in your Laravel project and add the `SqlMigrationServiceProvider` class to the list of providers, like this
```bash
    'providers' => [
        // Other service providers...
        BakkahIT\SqlMigration\SqlMigrationServiceProvider::class,
    ]
```


## Usage
### Step 1: Create a SQL Migration File
You can create a new SQL migration file by using the following Artisan command:

```bash
php artisan make:sql-migration create_test_table_sql
```
This command will generate a migration file inside the `database/migrations` directory, with a name following this format: `YYYY_MM_DD_HHMMSS_create_test_table_sql.php`. The `create_test_table_sql` part of the file name is the name you provide when running the command, and it will be used in the generated migration class as well.


### Step 2: Write SQL Queries in the Migration File
Once the migration file is created, you will see a class with `up()` and `down()` methods. You can define your SQL queries inside the `up()` method to apply changes to the database, and in the `down()` method to reverse them.

Example of a migration file with raw SQL to create a table:
```bash
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTestTableSql extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE TABLE test_table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP TABLE IF EXISTS test_table');
    }
}
```
In this example:
- The `up()` method contains the SQL statement to create the `test_table table`.
- The `down()` method contains the SQL statement to drop the `test_table table`.


### Step 3: Run Migrations
After writing the SQL commands in your migration file, you can run the migrations as usual using the following Artisan command:
```bash
php artisan migrate
```
This will execute all pending migrations, including the SQL-based migrations.

### Step 4: Rollback Migrations (Optional)
If you want to rollback the most recent migrations (including the SQL migrations), you can use the following command:
```bash
php artisan migrate:rollback
```
This will call the `down()` method in each migration, reversing any changes made in the `up()` method.

## Notes
- **SQL Query Validity:** Ensure the SQL queries in your migration files are valid for your database engine (e.g., MySQL, PostgreSQL).
- **No Table Modifications:** This package doesn't modify tables automatically. It simply runs the SQL queries you've written in the migration file.
- **Custom Queries:** You can write any custom SQL logic in your migrations as needed.

## Requirements
- **Laravel:** This package requires Laravel 8 or later.
- **Database**: It supports MySQL and other databases that allow raw SQL execution.

## Contributing
We welcome contributions to the package! If you'd like to improve the package, fix bugs, or add new features, feel free to fork the repository and submit a pull request.

- Fork the repository.
- Create a new branch for your feature or bug fix.
- Write tests to cover your changes.
- Submit a pull request.

## License
The `SqlMigration` package is open-source software licensed under the MIT License.

 