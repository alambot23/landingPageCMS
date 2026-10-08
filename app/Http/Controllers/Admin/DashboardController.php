<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $kartu = [];
        foreach (config('admin.resources') as $key => $c) {
            if ($key === 'slide') {
                continue;
            }
            $kartu[] = ['key' => $key, 'label' => $c['plural'], 'total' => $c['model']::count()];
        }

        return view('admin.dashboard', ['kartu' => $kartu]);
    }
}
