@extends('backend-theme::layout')

@section('content')
   <div>
       @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت یادداشت‌ها','url'=>url('note')],
            ['title'=>'جزییات یادداشت','url'=>url('note/'.$note->id)],
       ]])
       <?php
       $args = [];
       $args['title']='جزییات یادداشت: '.$note->title;

       ?>

       <x-panel-box :args="$args">

           <?php
           $get_note_detail=get_note_detail($note);
           $j=0;
           ?>
           <table class="table table-bordered order_table_info">
               @for($i=0;$i<sizeof($get_note_detail);$i++)
                   <tr>
                       <td class="pa-2" @if(array_key_exists($j,$get_note_detail)) colspan="2" style="text-align: center ; background-color: ghostwhite" @endif>
                           {{ $get_note_detail[$j]['label'] }}
                       </td>
                       <td class="pa-2"><span> {{ $get_note_detail[$j]['value'] }}</span></td>
                   </tr>
                   <?php $j++ ?>
               @endfor
           </table>

       </x-panel-box>

   </div>
@endsection


