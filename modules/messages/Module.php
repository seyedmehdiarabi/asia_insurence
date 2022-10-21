<?php


namespace Modules\messages;
use Auth;
use Modules\messages\Repository\MessageRepositoryInterface;
use View;
class Module
{
    public function set_user_access_list($access)
    {
        $access['message'] = [
            'label' => 'پیام‌ها',
            'access' => [
                'message_edit' => ['label' => 'ثبت و ویرایش پیام', 'routes' => [
                    'message.index', 'message.create', 'message.store', 'message.edit', 'message.update'
                ]],
                'remove_message' => ['label' => 'حذف پیام', 'routes' => ['message.index', 'message.destroy']],
                'restore_message' => ['label' => 'بازیابی پیام', 'routes' => ['message.index', 'message.restore']]
            ]
        ];
        return $access;
    }

    public function user_index_action(){
        return function ($model){
            $url=url('users/'.$model->id.'/messages');
            return view('messages::message_list_icon',['url'=>$url]);
        };
    }

    public function user_profile($data){
        $user_id=Auth::user()->id;
        $repository=app(MessageRepositoryInterface::class);
        $count=$repository->getNuwUserMessageCount($user_id);
        View::share('new_message_count',$count);
    }

    public function load_backend_data(){
        if(Auth::user()->role=='admin' || has_access_author_admin('message')){
            $repository=app(MessageRepositoryInterface::class);
            $message_count=$repository->count(['status'=>1]);
            View::share('message_count',$message_count);
        }
    }

    public function registerComponent(){
        if(config('view.messages')==='add'){
            return veu_component_detail('messages');
        }
    }

}
