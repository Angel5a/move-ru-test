<?php

namespace Angel5a\MoveRuTest;

/**
 * Tokenizer interface.
 */
interface HtmlTokenizerInterface
{
    /**
     * Get all tokens.
     * 
     * @return array  Array of collected tokens.
     */
    public function getTokens();
}
