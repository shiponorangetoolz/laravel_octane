<?php

namespace App\Helper\Poem;

class RandomPoemGenerator extends PoemGenerator
{
    public function data(): array
    {
        $data = parent::data();

        $shuffle = shuffle($data);
        return $data;
    }
}
