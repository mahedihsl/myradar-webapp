<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMessage;
use App\Contract\Repositories\MessageRepository;
use App\Presenters\MessagePresenter;
use App\Criteria\LastUpdatedCriteria;

class MessageController extends Controller
{
    /**
     * @var MessageRepository
     */
    private $repository;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->repository->pushCriteria(new LastUpdatedCriteria());
        return view('message.index')->with([
            'messages' => $this->repository->paginate(),
        ]);
    }

    public function store(CreateMessage $request)
    {
        $item = $this->repository->save(collect($request->all()));

        if ( ! $request->ajax()) {
            return redirect()->back();
        }

        if (is_null($item)) {
            return response()->error('Message Not Sent');
        }

        return response()->ok('Message Sent');
    }

    public function destroy(Request $request)
    {
        # code...
    }
}
