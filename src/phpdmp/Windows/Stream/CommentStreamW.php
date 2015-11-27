<?php

namespace phpdmp\Windows\Stream;

/*
The stream contains a Unicode string used for documentation purposes.
*/
class CommentStreamW extends Stream
{
    public function getData()
    {
        return iconv('UTF-16LE', 'UTF-8', $this->streamData);
    }
}
