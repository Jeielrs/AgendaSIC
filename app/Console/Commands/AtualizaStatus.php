<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AtualizaStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AtualizaStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando atualiza todos os status que estejam com a data e
    hora atual, filtrando na tabela Atualizações.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
