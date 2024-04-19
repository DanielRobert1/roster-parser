<?php

namespace App\Services;

use App\Interfaces\ParserInterface;
use App\Traits\CCNXHtmlParser;
use DOMDocument;
use DOMXPath;
use Exception;

class CCNXParser implements ParserInterface
{
    use CCNXHtmlParser;

    protected $startDate;
    protected $endDate;

    /**
     * Parse the HTML content to extract roster events.
     *
     * @param string $fileContents
     * @return array
     */
    public function parseHtml(string $fileContents): array
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($fileContents);

        $xpath = new DOMXPath($dom);

        // Extract the date peroid
        $selectedOption = $xpath->query("//select[option[@selected]]/option[@selected]");

        if ($selectedOption->length > 0) {
            $value = $selectedOption->item(0)->getAttribute('value');
            $dates = explode('|', $value);
            $startDate = \DateTime::createFromFormat('Y-m-d', $dates[0]);
            $endDate = \DateTime::createFromFormat('Y-m-d', $dates[1]);

            if(empty($startDate) || empty($endDate)){
                throw new Exception("Could not parse date peroid", 1);
            }

            $this->startDate = $startDate;
            $this->endDate = $endDate;
        }

        $events = [];

        $count = 0;
        $headers = null;
        $tables = $dom->getElementsByTagName('table');
        if(count($tables) < 1){
            throw new Exception("Could not find any tables to parse", 1);
        }
        $tableRows = $tables->item(0)->getElementsByTagName('tr');
        
        foreach ($tableRows as $row) {
            $columns = $row->getElementsByTagName('td');

            // Skip rows with insufficient columns
            if ($columns->length < 8) {
                continue;
            }

            // Parse header row to determine column names
            if ($count == 0) {
                $headers = $this->parseHtmlHeader($columns);
                $count++;
                continue;
            }

            // Parse the current row and add to events if valid
            $event = $this->parseHtmlRow($columns, $headers);

            if ($event) {
                $events[] = $event;
            }

            $count++;
        }

        return $events;
    }

    /**
     * Parse the TXT content to extract roster events.
     *
     * @param string $fileContents
     * @return array
     */
    public function parseTxt(string $fileContents): array
    {
        return [];
    }

    /**
     * Parse the PDF content to extract roster events.
     *
     * @param string $fileContents
     * @return array
     */
    public function parsePdf(string $fileContents): array
    {
        return [];
    }

    /**
     * Parse the CSV content to extract roster events.
     *
     * @param string $fileContents
     * @return array
     */
    public function parseCsv(string $fileContents): array
    {
        return [];
    }
}
