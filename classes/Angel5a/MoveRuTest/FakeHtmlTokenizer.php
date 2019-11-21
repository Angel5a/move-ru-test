<?php

namespace Angel5a\MoveRuTest;

/**
 * Test support class.
 */
class FakeHtmlTokenizer implements HtmlTokenizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTokens()
    {
        return [
            [HtmlTokenType::T_OPEN, 'div'],
            [HtmlTokenType::T_TEXT, 'Here is '],
            [HtmlTokenType::T_OPEN, 'a'],
            [HtmlTokenType::T_TEXT, 'a link'],
            [HtmlTokenType::T_CLOSE, 'a'],
            [HtmlTokenType::T_TEXT, ' some '],
            [HtmlTokenType::T_OPEN, 'b'],
            [HtmlTokenType::T_TEXT, 'bold text'],
            [HtmlTokenType::T_CLOSE, 'B'],
            [HtmlTokenType::T_TEXT, ' and '],
            [HtmlTokenType::T_OPEN, 'A'],
            [HtmlTokenType::T_TEXT, 'extra link'],
            [HtmlTokenType::T_CLOSE, 'A'],
            [HtmlTokenType::T_TEXT, '.'],
            [HtmlTokenType::T_CLOSE, 'div'],
            [HtmlTokenType::T_END, ''],
        ];
    }
}
