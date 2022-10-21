@extends('backend-theme::layout')

@section('content')

   <div>

       @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت دسته ها','url'=>url('category')]]])

       @include('categories::_search_form')

       <?php
            $args=['title'=>'مدیریت دسته ها'];
            $args['route']='category';
            $args['trashCount']=$trash_cat_count;
            $args['routeParam']='دسته';
       ?>

       <x-panel-box :args="$args">
           <?php
           \App\Lib\GridView::showTable([
               'dataProvider'=>$category,
               'tableLabel'=>'دسته',
               'route_param'=>'category',
               'columns'=>[
                   ['label'=>'نام دسته','attr'=>'name'],
                   ['label'=>'دسته والد','attr'=>function($model){
                       return $model->getParent->name ;
                   }]
               ]
           ]);
           ?>

           {{ $category->links() }}
       </x-panel-box>

   </div>

@endsection

