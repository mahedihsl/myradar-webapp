<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\UserRepository;
use App\Criteria\ModelTypeCriteria;
use App\Entities\User;
use App\Events\AccountStatusChanged;

class AccountController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;

        $criteria = new ModelTypeCriteria(User::$TYPE_CUSTOMER);
        $this->repository->pushCriteria($criteria);
    }

    public function info(Request $request, $id)
    {
        $user = $this->repository->find($id);

        if ( ! is_null($user)) {
            return response()->json([
                'status' => 1,
                'enabled' => $user->isEnabled(),
            ]);
        }

        return response()->json([ 'status' => 0 ]);
    }

    public function toggle(Request $request)
    {
        $user = $this->repository->find($request->get('id'));

        if ( ! is_null($user)) {
            $nextState = ! $user->isEnabled();

            if ( ! $nextState && ! $request->user()->isAdmin()) {
                return response()->error('You can not disable user account');
            }

            $user->update([ 'enabled' => $nextState ]);

            event(new AccountStatusChanged($user));

            return response()->ok([
                'enabled' => $user->isEnabled(),
            ]);
        }

        return response()->error('User Not Found, Try Again.');
    }
}
