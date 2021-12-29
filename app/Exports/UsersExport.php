<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return User::query()->with('posts');
    }

    public function map($row): array
    {
        $dataArray[] =[
            $row->id,
            ucwords($row->name),
            $row->email,
            $row->posts->first()->body ?? '',
            $row->created_at
        ];

        $counter = 0;
        foreach ($row->posts as $post) {
            # Skip first row, why? CUZ we added before start foreach loop. (above lines)
            if ($counter++ == 0) continue;
            $dataArray[] = [
                # Skip columns that's we don't need it here
                '',
                '',
                '',
                $post->body,
            ];
        }
        return $dataArray;
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
