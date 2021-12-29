<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;

class PostsExport implements FromQuery
{

    public function query()
    {
        return User::query()->with('posts');
    }


    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',
            'Posts',
            'Date Registered',
        ];
    }
}
