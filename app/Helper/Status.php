<?php

namespace App\Helper;

enum Status: int
{
    case DRAFT = 1;
    case PUBLISHED = 2;
    case ARCHIVED = 3;

    case DRAFT_TYPE = 4;
    case PUBLISHED_TYPE = 5;
    case ARCHIVED_TYPE = 6;

    public function color(): string
    {
        return match($this)
        {
            Status::DRAFT => 'grey',
            Status::PUBLISHED => 'green',
            Status::ARCHIVED => 'red',
        };
    }

    public function type(): string
    {
        return match($this)
        {
            Status::DRAFT_TYPE => 'good',
            Status::PUBLISHED_TYPE => 'better',
            Status::ARCHIVED_TYPE => 'best',
        };
    }
}
