<?php

namespace App\Models\MarkdownRender;

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
use App\Models\MarkdownRender\MarkdownRender;


class CommonMarkRender implements MarkdownRender
{

    private static ?MarkdownConverter $markdownConverter = null;

    private static function initConverter()
    {
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


        return new MarkdownConverter($environment);
    }



    public function render(string $markdown): string
    {
        if (self::$markdownConverter == null) {
            Self::$markdownConverter = Self::initConverter();
        }
        return self::$markdownConverter->convert($markdown);
    }
}
