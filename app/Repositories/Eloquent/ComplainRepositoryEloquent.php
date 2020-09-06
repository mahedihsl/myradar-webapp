<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\ComplainRepository;
use Illuminate\Support\Collection;
use App\Entities\Complain;
use App\Entities\Car;
use App\Events\ComplainClosed;
use App\Validators\ComplainValidator;
use Carbon\Carbon;
/**
 * Class ComplainRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ComplainRepositoryEloquent extends BaseRepository implements ComplainRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Complain::class;
    }

    public function save(Collection $data)
    {
        $car = Car::where('reg_no', $data->get('reg_no'))->first();
        $complain = $this->create([
                      'title' => $data->get('title'),
                      'body'  => $data->get('body'),
                      'emp'   => $data->get('emp'),
                      'type'  => $data->get('type'),
                      'reg_no'=> $data->get('reg_no'),
                      'status'=> $data->get('status'),
					  'responsible' => $data->get('responsible'),
                      'car_id'=> $car->id,
                      'token' => $this->generate(),
                      'when'  => Carbon::now(),
                    ]);
        return $complain;
    }

    public function change(Collection $data)
    {
        $responsible = $data->get('responsible');
        $newStatus = $data->get('new_status');
        $status    = $data->get('status');
        $type    = $data->get('type');

        $model = $this->find($data->get('id'));
        $comm = $model->comment;

        $ara['status'] = $newStatus;
        if($data->get('comment') != "") {
            array_push($comm, [
                'body' => $data->get('comment'),
                'who' => $data->get('who'),
				'when' => time(),
            ]);
            $ara['comment'] = $data->get('comment');
        }

        $model->update([
            'type' => $type,
            'status' => $newStatus,
            'comment' => $comm,
			'responsible' => $responsible,
        ]);

        // $complain = $this->update($ara, $data->get('id'));
        if($newStatus == 'closed' && $newStatus != $status){
          event(new ComplainClosed($model));
        }

        return $model;
    }

	public function statusCount($status)
	{
		return Complain::where('status', $status)->count();
	}

    public function generate()
    {
      while (true) {
          $token = rand(10000, 99999);

          if ( ! Complain::where('token', $token)->exists()) {
              return $token;
          }
      }
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
