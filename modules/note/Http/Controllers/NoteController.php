<?php

namespace Modules\note\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\note\Http\Requests\NoteRequest;
use Modules\note\Repository\NoteRepositoryInterface;
use View;

class NoteController extends CustomController
{
    protected $title='یادداشت‌ها';

    protected $route_params='note';

    protected $repository=null;

    public function __construct(NoteRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $note=$this->repository->getList($request);
        $trash_note_count=$this->repository->trashCount();
        return CView('note::index',['note'=>$note,'trash_note_count'=>$trash_note_count,'req'=>$request]);
    }

    public function create()
    {
        return CView('note::create');
    }

    public function store(NoteRequest $request)
    {
        $request['user_id'] = \Auth::user()->id;
        $this->repository->create($request);
        return  [
            'redirect_url'=>url('note'),
            'message'=>'ثبت یادداشت جدید با موفقیت انجام شد'
        ];

    }

    public function edit($id)
    {
        $note=$this->repository->find($id);
        return CView('note::edit',compact('note'));
    }

    public function update($id,NoteRequest $request)
    {
        $this->repository->update($id,$request);
        return  [
            'redirect_url'=>url('note'),
            'message'=>'ویرایش یادداشت با موفقیت انجام شد'
        ];
    }
    public function show($id)
    {
        $note=$this->repository->find($id);
        return CView('note::show',compact('note'));
    }
}
