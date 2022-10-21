<?php


namespace Modules\note\Repository;


use App\Repositories\BaseInterface;

interface NoteRepositoryInterface extends BaseInterface
{
    public function first($id);

    public function all($where = []);

    public function whereBetweenDate($where, $whereBetween);
}
