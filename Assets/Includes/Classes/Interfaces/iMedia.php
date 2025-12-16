<?php

namespace Site\Interfaces;

interface iMedia {

    public function getUrl(string $variant = 'original'): string;
}

?>