<?php

namespace App\Console\Commands;

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Models\Denuncias\Denuncia;
use Illuminate\Console\Command;

class RefreshStatusDenunciasCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $dens = Denuncia::query()
            ->select('id')
            ->orderByDesc('id')
            ->get();

        $vid = new VistaDenunciaClass();

        foreach ($dens as $den) {
            try {
                $vid->vistaDenuncia($den->id);
            }catch (\Exception $e) {
                // continue
            }
        }

        return 0;
    }
}
