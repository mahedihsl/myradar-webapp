<?php

namespace App\Http\Controllers\ServiceMonitor;

use App\Http\Controllers\Controller;
use App\Contract\Repositories\ComplainRepository;
use App\Presenters\ComplainPresenter;
use App\Presenters\ComplainExportPresenter;
use App\Criteria\LastCreatedCriteria;
use App\Criteria\ComplainUserNameCriteria;
use App\Criteria\ComplainTokenCriteria;
use App\Criteria\CarRegNoCriteria;
use Illuminate\Support\Collection;
use App\Events\ComplainCreated;
use App\Events\ComplainClosed;
use App\Entities\Complain;
use App\Entities\Car;
use App\Criteria\RecentItemCriteria;
use Illuminate\Http\Request;
use Excel;

class ComplainController extends Controller
{

    /**
    * @var ComplainRepository
    */

    private $repository;

    public function __construct(ComplainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
		$count = collect([
			'inv' => $this->repository->statusCount('investigating'),
			'opn' => $this->repository->statusCount('open'),
			'cls' => $this->repository->statusCount('closed'),
			'rsl' => $this->repository->statusCount('resolved'),
			'rep' => $this->repository->statusCount('replace'),
			'reo' => $this->repository->statusCount('reopen'),
		]);

		return view('service.complain')->with(['count' => $count]);
    }


    public function save(Request $request)
    {
      if($this->getWebUser()->isOperation())
        return response()->error("Sorry! you don't have access");
      $response = $this->validateCar(collect($request->all()));
      if($response['status'] == 0)
        return response()->error($response['data']);

      $complain = $this->repository->save(collect($request->all()));

      if(!is_null($complain)){
        event(new ComplainCreated($complain));
        return response()->ok();
      }

      return response()->error();
    }


    public function all(Request $request)
    {

      $items = $this->repository
	  	->setPresenter(ComplainPresenter::class)
	  	->pushCriteria(new LastCreatedCriteria)
		->paginate();

      return response()->ok($items);
    }

    public function search(Request $request)
    {

        $this->repository->setPresenter(ComplainPresenter::class);

        if (strlen($regNo = $request->get('reg_no', ''))) {
            $this->repository->pushCriteria(new CarRegNoCriteria($regNo));
        }

        if (strlen($name = $request->get('name', ''))) {
            $this->repository->pushCriteria(new ComplainUserNameCriteria($name));
        }

        if (strlen($token = $request->get('token', ''))) {

            $this->repository->pushCriteria(new ComplainTokenCriteria($token));
        }

        $this->repository->pushCriteria(new LastCreatedCriteria);
        return response()->ok($this->repository->paginate());
    }

    public function change(Request $request)
    {
      // $response = $this->getValidity(collect($request->all()));
      // if($response['status'] == 0)
      //   return response()->error($response['data']);

        $coll = collect($request->all());
        $coll->put('who', $request->user()->name);
      $complain = $this->repository->change($coll);

      if(!is_null($complain)){
        return response()->ok();
      }

      return response()->error();
    }

    public function validateCar(Collection $data){
      $car = Car::where('reg_no', $data->get('reg_no'))->first();
      if(is_null($car))
        return ['status' => 0, 'data' => 'car not found'];

      return ['status' => 1, 'data' => ''];
    }

    public function getValidity(Collection $data){

      $loggedUser = $this->getWebUser();
      $status     = $data->get('new_status');
      $oldStatus  = $data->get('status');
      $comment     = $data->get('comment');
      if(($loggedUser->isAgent() && ($status == 'investigating' || $status == 'resolved')))
      {
        return ['status' => 0, 'data' => 'Sorry! you dont have access'];
      }
      else if(($loggedUser->isOperation() && (($status == 'open' || $status == 'closed') && $oldStatus != $status))){
        return ['status' => 0, 'data' => 'Sorry! you dont have access'];
      }
      return ['status' => 1, 'data' => ''];
    }

	public function export(Request $request)
	{
		$items = $this->repository
  	  		->setPresenter(ComplainExportPresenter::class)
  	  		->pushCriteria(new LastCreatedCriteria)
			->with(['car.user'])
  			->get();
		Excel::create('Complains', function ($excel) use ($items) {
            $excel->sheet('data', function ($sheet) use ($items) {

                $sheet->fromArray($items['data'], null, 'A1', false, true);
            });
        })->download('xls');

        return redirect()->back();
	}

}
