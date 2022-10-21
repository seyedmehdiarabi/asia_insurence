<?php

Route::middleware(['auth', 'user'])->group(function () {
    create_crud_route('note', 'NoteController', []);
});

