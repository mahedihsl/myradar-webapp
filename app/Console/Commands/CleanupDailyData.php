<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Contract\Repositories\PositionRepository;
use App\Contract\Repositories\GasHistoryRepository;
use App\Contract\Repositories\FuelHistoryRepository;

class CleanupDailyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:cleanup {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup DB by deleting lat/lng, gas, fuel data of specific date';

    /**
     * list of repositories to be cleaned
     * @var Collection
     */
    private $repositories;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->repositories = collect([
            PositionRepository::class,
            GasHistoryRepository::class,
            FuelHistoryRepository::class,
        ]);
    }

    private function date()
    {
        try {
            return Carbon::createFromFormat('Y-m-d', $this->argument('date'));
        } catch (\Exception $e) {
            return null;
        }
    }

    private function cleanup($repository, $date)
    {
        $next = $date->copy()->addDay();
        $repository->scopeQuery(function($query) use ($date, $next) {
            return $query->where('when', '>=', $date)
                        ->where('when', '<', $next);
        })->deleteWhere([]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ( ! is_null($date = $this->date())) {
            $this->repositories->each(function($repo) use ($date) {
                $this->cleanup(resolve($repo), $date);
            });
        } else {
            $this->info('provide date argument in Y-m-d format');
        }
    }
}
