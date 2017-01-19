<?php

namespace App;

class Node
{
    /**
     * Create node
     *
     * @var array $data
     * @return array
     */
    public function __construct($data)
    {
        $this->data = (object)$data;
        $this->children = array();
    }

    /**
     * Add child
     *
     * @var object $node
     * @return void
     */
    public function addChild(& $node)
    {
        $node->data->depth = $this->data->depth + 1;
        $this->children[] = $node;
    }
}
