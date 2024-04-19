<?php

namespace App\Interfaces;

interface ParserInterface
{
    /**
     * @param string $htmlContent
     *
     * @return array
     */
    public function parseHtml(string $htmlContent): array;

    /**
     * @param string $csvContent
     *
     * @return array
     */
    public function parseCsv(string $csvContent): array;

    /**
     * @param string $pdfContent
     *
     * @return array
     */
    public function parsePdf(string $pdfContent): array;

    /**
     * @param string $txtContent
     *
     * @return array
     */
    public function parseTxt(string $txtContent): array;
}