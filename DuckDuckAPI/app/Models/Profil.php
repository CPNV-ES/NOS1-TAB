<?php

namespace App\Models;

use Laudis\Neo4j\Types\Node;

class Profil
{
    public string $id;
    public string $name;
    public string $image_url;
    public string $hash;
    public string $created_at;
    public string $updated_at;

    public function __construct(
        string $id,
        string $name,
        string $image_url,
        string $hash,
        string $created_at,
        string $updated_at
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->image_url = $image_url;
        $this->hash = $hash;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromNode(Node $node): self
    {
        $props = $node->getProperties()->toArray();

        return new self(
            $props['id'],
            $props['name'],
            $props['image_url'],
            $props['hash'],
            $props['created_at'],
            $props['updated_at']
        );
    }

    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'image_url'  => $this->image_url,
            'hash'       => $this->hash,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}