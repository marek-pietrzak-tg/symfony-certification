<?php

namespace AppBundle\Utils;


class Markdown
{
    public function __construct()
    {
        $this->parser = new \Parsedown();
    }

    public function toHtml($text)
    {
        return $this->parser->text($text);
    }
}
