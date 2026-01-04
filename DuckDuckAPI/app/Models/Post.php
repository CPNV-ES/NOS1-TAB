<?php

namespace App\Models;

use Laudis\Neo4j\Types\Node;

class Post
{
    public string $id;
    public string $description;
    public string $image_url;
    public string $created_at;
    public string $updated_at;

    public function __construct(string $id, string $description, string $image_url, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->description = $description;
        $this->image_url = $image_url;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromNode(Node $node): self
    {
        $props = $node->getProperties()->toArray();

        return new self(
            $props['id'],
            $props['description'],
            $props['image_url'],
            $props['created_at'],
            $props['updated_at'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}