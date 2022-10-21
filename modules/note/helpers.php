<?php

function get_note_detail($note)
{
    $array = [];
    if ($note->title) {
        $array[] = [
            'label' => 'عنوان یادداشت :',
            'value' => e($note->title)
        ];
    }
    if ($note->start_time) {
        $array[] = [
            'label' => 'تاریخ یادآوری :',
            'value' => get_calendar($note->date, true)
        ];
    }
    if ($note->description) {
        $array[] = [
            'label' => 'توضیحات :',
            'value' => e($note->description)
        ];
    }

    return $array;
}

