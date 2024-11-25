<?php

namespace BakkahIT\SqlMigration\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Str;

class SqlMigrationTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \BakkahIT\SqlMigration\SqlMigrationServiceProvider::class,
        ];
    }
    protected function setUp(): void
    {
        parent::setUp();

        $this->clearMigrations();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->clearMigrations();
    }

    private function clearMigrations(): void
    {
        $files = File::files(database_path('migrations'));
        foreach ($files as $file) {
            File::delete($file->getPathname());
        }
    }

    /** @test */
    public function it_creates_an_sql_migration_file()
    {
        $name = 'CreateTestTableSql';

        Artisan::call('make:sql-migration', ['name' => $name]);

        $files = File::files(database_path('migrations'));
        $this->assertCount(1, $files);

        $content = File::get($files[0]->getPathname());
        $this->assertStringContainsString('DB::unprepared', $content);
    }

    /** @test */
    public function it_runs_the_sql_migration()
    {
        $name = 'CreateUsersTableSql';
        Artisan::call('make:sql-migration', ['name' => $name]);

        $files = File::files(database_path('migrations'));
        $file = $files[0];
        $this->assertNotNull($file);

        File::put($file->getPathname(), <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Support\\Facades\\DB;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared("CREATE TABLE test_users (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255));");
    }

    public function down()
    {
        DB::unprepared("DROP TABLE test_users;");
    }
};
PHP);

        Artisan::call('migrate');

        $this->assertTrue(Schema::hasTable('test_users'));

        Artisan::call('migrate:rollback');

        $this->assertFalse(Schema::hasTable('test_users'));
    }
}
