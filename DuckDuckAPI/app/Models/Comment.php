<?php

namespace App\Models;

use Laudis\Neo4j\Types\Relationship;

class Comment
{
    public string $id;
    public string $from_id;
    public string $text;
    public string $created_at;
    public string $updated_at;

    public function __construct(string $id, string $from_id, string $text, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->from_id = $from_id;
        $this->text = $text;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromRelationship(Relationship $rel, string $from_id): self
    {
        $props = $rel->getProperties()->toArray();

        return new self(
            $props['id'],
            $from_id,
            $props['text'],
            $props['created_at'],
            $props['updated_at']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'from_id' => $this->from_id,
            'text' => $this->text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}