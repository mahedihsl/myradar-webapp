<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contract\Repositories\EventRepository;
use App\Contract\Repositories\PerformanceRepository;
use App\Entities\Car;
use App\Entities\Event;
use App\Criteria\CarIdCriteria;
use App\Criteria\ModelTypeCriteria;
use App\Criteria\WithinDatesCriteria;
use Carbon\Carbon;

class CalculatePerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var PerformanceRepository
     */
    private $repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PerformanceRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cars = Car::with('device')->get();
        foreach ($cars as $car) {
            if ( ! $car->device) continue;

            $events = $this->getEvents($car)->filter(function($o) {
                return isset($o->meta['lat']) && isset($o->meta['gas']);
            });
            $posCount = $events->sum(function($item) { return $item->meta['lat']; });
            $gasCount = $events->sum(function($item) { return $item->meta['gas']; });

            if ( ! $gasCount) {
                $deviation = 0;
            } else {
                $deviation = floor(($gasCount - $posCount) / $gasCount * 100);
            }

            $this->repository->create([
                'lat'       => $posCount,
                'gas'       => $gasCount,
                'deviation' => $deviation,
                'car_id'    => $car->id,
                'device_id' => $car->device->id,
                'when'      => Carbon::today(),
            ]);
        }
    }

    public function getEvents($car)
    {
        return resolve(EventRepository::class)
                ->skipPresenter()
                ->pushCriteria(new CarIdCriteria($car->id))
                ->pushCriteria(new ModelTypeCriteria(Event::TYPE_OFF))
                ->pushCriteria(new WithinDatesCriteria(Carbon::yesterday(), Carbon::yesterday()))
                ->all();
    }
}
