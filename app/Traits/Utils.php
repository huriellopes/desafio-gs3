<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Utils
{
    /**
     * @param string $value
     * @return string
     */
    public function clear_tags(string $value) : string
    {
        return preg_replace('(<(/?[^\>]+)>)', '', trim($value));
    }

    /**
     * @param $value
     * @return bool
     * @throws \Exception
     */
    public function isInt($value) : bool
    {
        if (!is_integer($value)) {
            throw new \Exception('O parâmetro informado deve ser um inteiro.', 400);
        }

        return true;
    }

    /**
     * @param string $name
     * @return string
     */
    public function set_slug(string $name) : string
    {
        return Str::before(Str::slug($name), '-');
    }
}
