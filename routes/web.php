<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\MarkdownConverter;


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
    $config = [
        'heading_permalink' => [
            'html_class' => 'card-title title',
            'id_prefix' => '',
            'apply_id_to_heading' => false,
            'heading_class' => '',
            'fragment_prefix' => '',
            'insert' => 'before',
            // 'min_heading_level' => 1,
            // 'max_heading_level' => 6,
            'title' => 'Permalink',
            'symbol' => '#',
            'aria_hidden' => true,
        ],
    ];
    $environment = new Environment($config);
    $environment->addExtension(new CommonMarkCoreExtension());

    // Remove any of the lines below if you don't want a particular feature

    $environment->addExtension(new SmartPunctExtension());
    $environment->addExtension(new AutolinkExtension());
    $environment->addExtension(new DisallowedRawHtmlExtension());
    $environment->addExtension(new StrikethroughExtension());
    $environment->addExtension(new TableExtension());
    $environment->addExtension(new TaskListExtension());
    $environment->addExtension(new HeadingPermalinkExtension());


    $converter = new MarkdownConverter($environment);
    $html = $converter->convert($markdown_content);
    return view('markdown_doc', ['markdownContent' => $html]);
});
