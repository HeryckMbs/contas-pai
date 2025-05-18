<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeService extends Command
{

    protected $signature = 'make:service {nome}';


    protected $description = 'Gera um service padrão';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $nome = $this->argument('nome');
        $path = app_path("Http/Service/{$nome}.php");
        $templatePath = resource_path('stubs/Service.php');
        if (!file_exists($templatePath)) {
            $this->error("O template Service.php não foi encontrado!");
            return;
        }
    
        $template = file_get_contents($templatePath);
    
        // Substitua variáveis no template, se necessário
        $template = str_replace('{{ nome }}', $nome, $template);
    
        file_put_contents($path, '<?php '. PHP_EOL .$template);
        $this->info("Arquivo {$nome}Service.php criado com sucesso em MeusArquivos/");
    
    }
}
