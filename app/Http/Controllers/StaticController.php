<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StaticController extends Controller
{
    public function show($path = '')
    {
        $baseUrl = config('proxy.base_url');
        $sanitizedPath = strip_tags($path);

        $username = config('proxy.auth.username');
        $password = config('proxy.auth.password');

        $proxiedRequest = Http::withBasicAuth($username, $password)->get("{$baseUrl}/{$sanitizedPath}");

        $view = $proxiedRequest->body();

        return response($view, $proxiedRequest->status(), [
            'Content-Type' => $proxiedRequest->header('Content-Type')
        ]);
    }
}
