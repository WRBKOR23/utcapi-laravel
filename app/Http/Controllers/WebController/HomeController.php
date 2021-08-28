<?php

    namespace App\Http\Controllers\WebController;

    use App\Http\Controllers\Controller;

    class HomeController extends Controller
    {
        public function showHome ()
        {
            return view('home');
        }
    }
