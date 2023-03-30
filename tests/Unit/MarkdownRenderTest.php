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

    public function test_javascript(): void
    {
        $r = new CommonMarkRender();
        $script_tag = '<script>
alert("Hello JavaScript!");
</script>';
        $html = $r->render($script_tag);

        $this->assertFalse(str_contains($html, '<script>'));
    }

    public function test_table(): void
    {

        $normalCenterRightTable = '
th | th(center) | th(right)
---|:----------:|----------:
td | td         | td';


        $leftCenterRightTable = '
 th(left) | th(center) | th(right)
:---|:----------:|----------:
 td | td         | td';

        $expectedNormalCenterRight = '<table>
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

        $expectedLeftCenterRight = '<table>
<thead>
<tr>
<th align="left">th(left)</th>
<th align="center">th(center)</th>
<th align="right">th(right)</th>
</tr>
</thead>
<tbody>
<tr>
<td align="left">td</td>
<td align="center">td</td>
<td align="right">td</td>
</tr>
</tbody>
</table>
';
        $markdownTables = [
            $normalCenterRightTable,
            $leftCenterRightTable,
        ];
        $expectedHtmlTables = [
            $expectedNormalCenterRight,
            $expectedLeftCenterRight
        ];

        $r = new CommonMarkRender();

        for ($i = 0; $i < 2; $i++) {

            $html = $r->render($markdownTables[$i]);
            $this->assertEquals($expectedHtmlTables[$i], $html);
        }
    }
}
