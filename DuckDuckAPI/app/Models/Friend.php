<?php

namespace App\Models;

class Friend
{
    public string $from_id;
    public string $to_id;
    public string $created_at;

    public function __construct(string $from_id, string $to_id, string $created_at)
    {
        $this->from_id = $from_id;
        $this->to_id = $to_id;
        $this->created_at = $created_at;
    }

    public static function fromRelationship($rel, $from_id, $to_id): self
    {
        return new self(
            $from_id,
            $to_id,
            $rel->get('created_at')
        );
    }

    public function toArray(): array
    {
        return [
            'from_id' => $this->from_id,
            'to_id' => $this->to_id,
            'created_at' => $this->created_at,
        ];
    }
}
