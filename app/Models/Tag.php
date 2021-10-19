<?php

namespace App\Models;

class Tag {
    private string $tag_id;
    private ?string $product_id;

    public function __construct(string $tag_id, ?string $product_id = null)
    {
        $this->tag_id = $tag_id;
        $this->product_id = $product_id;
    }

    public function getTagId(): string
    {
        return $this->tag_id;
    }

    public function getProductId(): string
    {
        return $this->product_id;
    }
}
