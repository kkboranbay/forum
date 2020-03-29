<?php

namespace App\Inspections;


class InvalidKeywords
{
    protected $keywords = [
        'Customer support'
    ];

    /**
     * Detect spam
     *
     * @param $body
     * @throws \Exception
     */
    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contains spam.');
            }
        }
    }
}