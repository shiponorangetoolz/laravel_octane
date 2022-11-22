<?php

namespace App\Helper\Poem;

class GeneratorClass{

    public static function generatorPoem()
    {
        $generator = new PoemGenerator();

        $generator = $generator->generate(4);
        echo $generator;

    }
}
