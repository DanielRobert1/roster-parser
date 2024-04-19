<?php

namespace App\Interfaces;

use Illuminate\Http\UploadedFile;

interface RosterParserInterface
{
    /**
     * @param UploadedFile $uploadedFile
     * @param string $format
     *
     * @return array
     */
    public function parseFile(UploadedFile $uploadedFile, string $format = "CCNX"): array;
}