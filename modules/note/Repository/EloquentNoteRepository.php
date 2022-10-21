<?php


namespace Modules\note\Repository;


use App\Repositories\EloquentBaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\note\Models\Note;

class EloquentNoteRepository extends EloquentBaseRepository implements NoteRepositoryInterface
{
    protected $model = 'Modules\note\Models\Note';

    public function find($id)
    {
        return Note::findOrFail($id);
    }

    public function create($request)
    {
        $data = $request->all();
        $request['user_id'] = \Auth::user()->id;
        if ($request->has('status')) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $note = new Note($data);
        $note->saveOrFail();
    }

    public function trashCount()
    {
        return Note::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Note::getData($request->all());
    }

    public function update($id, $request)
    {
        $data = $request->all();
        if ($request->has('status')) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $note = Note::findOrFail($id);
        $note->update($data);
    }

    public function first($id)
    {
        return Note::find($id);
    }

    public function all($where = [])
    {
        return Note::where($where)->with('getUsersName')->get();
    }

    public function whereBetweenDate($where,$whereBetween)
    {
        return Note::where($where)->whereBetween('date', $whereBetween)->with('getUsersName')->orderBy('date','DESC')->get();
    }
}
