<?php

namespace Tests\Unit;

use App\Models\MarkdownRender\CommonMarkRender;
use PHPUnit\Framework\TestCase;

class MarkdownRenderTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_header_link(): void
    {
        $r = new CommonMarkRender();

        $markdownTitles = [
            '# title',
            '## title',
            '### title',
            '#### title',
            '##### title',
            '###### title',
        ];

        foreach ($markdownTitles as $markdown) {
            $html = $r->render($markdown);
            $expectedLink = 'href="#title"';
            $this->assertTrue(str_contains($html, $expectedLink));
        }
    }

    public function test_table(): void
    {

        $markdownTable = '
th | th(center) | th(right)
---|:----------:|----------:
td | td         | td';

        $expectedHtml = '<table>
<thead>
<tr>
<th>th</th>
<th align="center">th(center)</th>
<th align="right">th(right)</th>
</tr>
</thead>
<tbody>
<tr>
<td>td</td>
<td align="center">td</td>
<td align="right">td</td>
</tr>
</tbody>
</table>
';

        $r = new CommonMarkRender();
        $html = $r->render($markdownTable);
        $this->assertEquals($expectedHtml, $html);
    }
}
