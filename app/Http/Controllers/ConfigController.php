<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\SsrReport;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ConfigController extends Controller
{
    public function ssr()
    {
        $categories = Config::getItem('ssr_categories');

        if ($categories) {
            $categories = implode("\n", $categories);
        }

        return view(request('view'), compact('categories'));
    }


    public function saveSsr()
    {
        request()->validate([
            'ssr_categories' => 'required|string',
        ]);

        $categories = str_replace("\r", '', request('ssr_categories'));
        $categories = trim($categories);
        $categories = explode("\n", $categories);
        $categories = array_map('trim', $categories);
        $categories = array_filter($categories);
        sort($categories, 0);

        Config::updateOrCreate(
            ['key' => 'ssr_categories'],
            ['value' => $categories]
        );

        return $this->ssr();
    }
}
