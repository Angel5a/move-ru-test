<?php

namespace Angel5a\MoveRuTest;

class HtmlTokenizer implements HtmlTokenizerInterface
{
    /**
     * @var  string  Input text
     */
    private $input = '';

    /**
     * @var  array|null  Parsed tokens cache.
     */
    private $tokens = null;

    /**
     * Constructor.
     * 
     * @param  string $str  Input HTML string.
     */
    public function __construct($str)
    {
        $this->input = $str;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokens()
    {
        if($this->tokens === null) {
            $this->parseInput();
        }
        return $this->tokens;
    }

    /**
     * Calls on tag matched text.
     * 
     * @param  string  $text  Matched text.
     */
    private function matched($text) {
        //echo 'match: ' . htmlspecialchars($text) . '<br>';
        $matches = [];
        $pattern = '/^<(\\/?+)([-_a-zA-Z0-9]++)([^>]*+)>$/';    // Parse tag
        if (preg_match($pattern, $text, $matches) !== 1) {
            throw new \LogicException('Tag pattern missmatch on \'' . $text . '\'');
        }
        $type = empty($matches[1]) ? HtmlTokenType::T_OPEN : HtmlTokenType::T_CLOSE;
        $name = $matches[2];
        $rest = $matches[3];
        $this->tokens[] = [$type, $name, $rest, $text];
    }

    /**
     * Calls on non tag text
     * 
     * @param  string  $text
     */
    private function unmatched($text) {
        //echo 'unmatch: ' . htmlspecialchars($text) . '<br>';
        $this->tokens[] = [HtmlTokenType::T_TEXT, $text];
    }

    /**
     * Parse input.
     */
    private function parseInput()
    {
        $string = $this->input;
        $this->tokens = [];
        $matches = [];
        $pos = 0;
        $pattern = '/<\\/?+[-_a-zA-Z0-9][^>]*>/';    // Only tar detection needed here
        while (($ret = preg_match($pattern, $string, $matches, PREG_OFFSET_CAPTURE, $pos))  === 1) {
            $match = $matches[0][0];
            $newpos = $matches[0][1];
            if ($newpos > $pos) {
                $this->unmatched(substr($string, $pos, $newpos - $pos));
            }
            $this->matched($match);
            // move to next
            $pos = $newpos + strlen($match);
            if ($pos == $newpos) {
                throw new \LogicException('Parse pattern should not allow empty string');
            }
        }
        if($pos != strlen($string)) {
            $this->unmatched(substr($string, $pos));
        }

        $this->tokens[] = [HtmlTokenType::T_END, ''];
    }
}
