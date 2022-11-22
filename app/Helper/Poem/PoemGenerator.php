<?php


namespace App\Helper\Poem;

class PoemGenerator
{
    private static array $data = [
        'the horse and the hound and the horn that belonged to',
        'the farmer sowing his corn that kept',
        'the rooster that crowed in the morn that woke',
        'the priest all shaven and shorn that married',
        'the man all tattered and torn that kissed',
        'the maiden all forlorn that milked',
        'the cow with the crumpled horn that tossed',
        'the dog that worried',
        'the cat that killed',
        'the rat that ate',
        'the malt that lay in',
        'the house that Jack built',
    ];

    public function generate(int $number): string
    {
        return "This is {$this->phrase($number)}.";
    }

    protected function phrase(int $number): string
    {
        $parts = array_slice(self::$data, -$number, $number);

        return implode("\n        ", $parts);
    }

    protected function data()
    {
        return [
            'the horse and the hound and the horn that belonged to',
            // …
            'the house that Jack built',
        ];
    }
}


