<?php


namespace App\Markdown;


class Markdown
{
    protected $parser;

    public function __construct(\Parsedown $parser)
    {
        $this->parser = $parser;
    }

    public function toHtml($content)
    {
        $this->parser->setBreaksEnabled(true);
        $this->parser->setSafeMode(true);
        $this->parser->setMarkupEscaped(true);
        $html = $this->parser->text($content);

        return $html;
    }
}