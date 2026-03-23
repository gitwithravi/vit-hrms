<?php

namespace App\Http\Controllers;

class Search extends Controller
{
    /**
     * Search items
     */
    public function __invoke()
    {
        return [
            [
                'label' => 'User',
                'url' => 'UserList'
            ],
            [
                'label' => 'Todo',
                'url' => 'UtilityTodo'
            ],
            [
                'label' => 'Backup',
                'url' => 'UtilityBackup'
            ]
        ];
    }
}
