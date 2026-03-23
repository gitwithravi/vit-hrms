<?php

namespace App\Services\Dashboard;

use App\Models\Utility\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserAgendaService
{
    public function getData(Request $request): array
    {
        $todos = Todo::query()
            ->whereUserId(auth()->id())
            ->where('due_date', '<=', today()->addWeek(1)->toDateString())
            ->orderBy('due_date', 'desc')
            ->take(5)
            ->get();

        $agenda = [];

        foreach ($todos as $todo) {
            $detail = $this->getDetail($todo);

            array_push($agenda, [
                'title' => $todo->title,
                'date' => $todo->due,
                'icon' => Arr::get($detail, 'icon'),
                'color' => Arr::get($detail, 'color'),
            ]);
        }

        return $agenda;
    }

    private function getDetail(Todo $todo): array
    {
        if ($todo->completed_at->value) {
            return ['icon' => 'fas fa-check', 'color' => 'bg-success'];
        } elseif ($todo->due_date->value > today()->toDateString()) {
            return ['icon' => 'fas fa-clock', 'color' => 'bg-info'];
        } elseif ($todo->due_date->value == today()->toDateString()) {
            return ['icon' => 'fas fa-exclamation', 'color' => 'bg-warning'];
        } elseif ($todo->due_date->value < today()->toDateString()) {
            return ['icon' => 'fas fa-times', 'color' => 'bg-danger'];
        }
    }
}
