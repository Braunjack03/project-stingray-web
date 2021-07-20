<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    $restaurants = [
        [
            'id' => 1,
            'name' => 'Cafe Badilico',
            'type' => 'Italian, Cafe',
            'description' => 'Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.',
            'img' => 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
            'ratings' => [
                'score' => 4.5,
                'total' => 403
            ]
        ],
        [
            'id' => 2,
            'name' => 'Grilled Cheese Master',
            'type' => 'American, Fast',
            'description' => 'Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.',
            'img' => 'https://images.unsplash.com/photo-1528736235302-52922df5c122?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8Z3JpbGxlZCUyMGNoZWVzZXxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60',
            'ratings' => [
                'score' => 4.5,
                'total' => 403
            ]
        ],
        [
            'id' => 3,
            'name' => 'Asian Bistro',
            'type' => 'Asian, Casual',
            'description' => 'Small plates - an intimate setting with 12 indoor seats plus patio seating.',
            'img' => 'https://images.unsplash.com/photo-1569246294372-ed319c674f14?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1534&q=80',
            'ratings' => [
                'score' => 4.5,
                'total' => 403
            ]
        ]
    ];
    
    return Inertia::render('home', ['restaurants' => $restaurants]);
});

Route::get('/contact', function() {
    return Inertia::render('contact');
});