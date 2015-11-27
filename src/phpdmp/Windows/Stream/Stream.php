<?php

namespace phpdmp\Windows\Stream;

abstract class Stream
{
    protected $streamData;

    public function __construct($streamData)
    {
        $this->streamData = $streamData;
    }
}
