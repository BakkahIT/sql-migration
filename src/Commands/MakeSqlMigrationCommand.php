<?php

namespace BakkahIT\SqlMigration\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeSqlMigrationCommand extends Command
{
    protected $signature = 'make:sql-migration {name}';
    protected $description = 'Create a new SQL migration file';

    public function handle()
    {
        $name = $this->argument('name');
        $fileName = date('Y_m_d_His') . '_' . Str::snake($name) . '.php';

        $template = $this->getTemplate($name);

        $path = database_path('migrations/' . $fileName);

        File::put($path, $template);

        $this->info("SQL migration created: {$fileName}");
    }

    private function getTemplate($name)
    {
        return <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Support\\Facades\\DB;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared(<<<SQL
        -- أدخل هنا أوامر SQL
        SQL);
    }

    public function down()
    {
        DB::unprepared(<<<SQL
        -- أدخل هنا أوامر SQL للإلغاء
        SQL);
    }
};
PHP;
    }
}
