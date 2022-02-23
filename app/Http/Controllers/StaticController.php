<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StaticController extends Controller
{
    public function show($path = '/')
    {
        $baseUrl = config('proxy.base_url');
        $sanitizedPath = strip_tags($path);

        $username = config('proxy.auth.username');
        $password = config('proxy.auth.password');
        $requestUrl = "{$baseUrl}{$sanitizedPath}";

        Log::info("Requesting from {$requestUrl}");
        $proxiedRequest = Http::withBasicAuth($username, $password)->get($requestUrl);

        $view = $proxiedRequest->body();

        return response($view, $proxiedRequest->status(), [
            'Content-Type' => $proxiedRequest->header('Content-Type')
        ]);
    }
}
