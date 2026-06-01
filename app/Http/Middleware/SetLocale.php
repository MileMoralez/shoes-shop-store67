<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App; // 👈 ត្រូវប្រាកដថាមានបន្ទាត់នេះដាច់ខាត!
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // ឆែកមើលបើមានការចងចាំភាសាក្នុង Session
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale')); // បញ្ជាឱ្យ Laravel ប្តូរភាសាភ្លាម!
        } else {
            App::setLocale('en'); // បើអត់ទាន់មានទេ ឱ្យចេញអង់គ្លេសសិន
        }

        return $next($request);
    }
}