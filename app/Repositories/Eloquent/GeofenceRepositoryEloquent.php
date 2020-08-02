<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\GeofenceRepository;
use App\Entities\User;
use App\Entities\Geofence;
// use App\Presenters\FencePresenter;

/**
 * Class FenceRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class GeofenceRepositoryEloquent extends BaseRepository implements GeofenceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Geofence::class;
    }

    // public function presenter()
    // {
    //     return FencePresenter::class;
    // }

    public function save(Collection $data, User $user)
    {
        return $this->create([
            'name' => $data->get('name'),
            'vertices' => [
                'type' => 'Polygon',
                'coordinates' => $data->get('coordinates'),
            ],
            'user_id' => $user->id,
        ]);
    }

    public function ofUser($userId)
    {
        return $this->scopeQuery(function($query) use ($userId) {
            return $query->where('user_id', $userId)
                ->orderBy('created_at', 'desc');
        })->get();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
