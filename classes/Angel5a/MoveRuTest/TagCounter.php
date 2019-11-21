<?php

namespace Angel5a\MoveRuTest;

class TagCounter
{
    private $tokenizer = null;
    private $tags = null;

    public function __construct(HtmlTokenizerInterface $tokenizer)
    {
        $this->tokenizer = $tokenizer;
    }

    public function getTagCounts()
    {
        if($this->tags === null) {
            $this->parseTokens();
        }
        return $this->tags;
    }

    private function parseTokens()
    {
        $tokens = $this->tokenizer->getTokens();
        $this->tags = [];
        foreach ($tokens as $token) {
            $tokenType = $token[0];
            switch($tokenType) {
                case HtmlTokenType::T_OPEN:
                    $tagName = strtolower($token[1]);
                    if(empty($this->tags[$tagName])) {
                        $this->tags[$tagName] = 1;
                    } else {
                        $this->tags[$tagName]++;
                    }
                    break;
            }
        }
    }
}
