<?php

namespace App\Models;

class TagsCollection {
    private ?array $tags;

    public function __construct(array $tags = [])
    {
        $this->tags = $tags;
    }

    public function insertTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }
}