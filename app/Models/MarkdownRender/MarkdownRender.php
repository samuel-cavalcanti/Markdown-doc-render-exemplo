<?php

namespace App\Models\MarkdownRender;

interface MarkdownRender
{
    /**
     * render markdown content
     * @return string Html
     */
    public function render(string $markdown): string;
}
