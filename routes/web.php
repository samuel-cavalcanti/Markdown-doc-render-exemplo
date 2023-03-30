<?php

use App\Models\MarkdownRender\CommonMarkRender;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/comandos', function () {
    $markdown_file_path =  resource_path() . "/views/comandos.md";
    $markdown_content = File::get($markdown_file_path);
    $markdownRender = new CommonMarkRender();
    $html = $markdownRender->render($markdown_content);


    return view('markdown_doc', ['markdownContent' => $html]);
});
