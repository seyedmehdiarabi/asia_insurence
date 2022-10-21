<?php


namespace Modules\note;

use Modules\note\Repository\NoteRepositoryInterface;

class Module
{
    public function set_user_access_list($access)
    {
        $access['official'] = [
            'label' => 'یادداشت‌ها',
            'access' => [
                'note_edit' => ['label' => 'ثبت و ویرایش یادداشت', 'routes' => [
                    'note.index', 'note.create', 'note.store', 'note.edit', 'note.update'
                ]],
                'remove_note' => ['label' => 'حذف یادداشت', 'routes' => ['note.index', 'note.destroy']],
                'restore_note' => ['label' => 'بازیابی یادداشت', 'routes' => ['note.index', 'note.restore']]
            ]
        ];
        return $access;
    }

    public function before_show_view($data)
    {
        $routeName = getRouteName();
        if ($routeName == 'author_panel' || $routeName == 'admin_index') {
            $user = ['user_id' => \Auth::user()->id];
            $repository = app(NoteRepositoryInterface::class);
            return $this->getTaskFollowVisit($data, $repository, $user);
        }
    }

    public function admin_author_panel(): array
    {
        return [
            [
                'view' => 'note::dashboard.list',
                'index' => 0
            ],
        ];
    }

    public function admin_panel_index(): array
    {
        return [
            [
                'view' => 'note::dashboard.list',
                'index' => 0
            ],
        ];
    }

    protected function getTaskFollowVisit($data, $repository, $user)
    {
        $whereBetween = time_interval_tasks('-3 day', '+4 day');
        $where ['status'] = 0;
        $where['user_id'] = $user;
        $data['notes'] = $repository->whereBetweenDate($where, $whereBetween);
        return $data;
    }

}
