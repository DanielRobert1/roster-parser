<?php

namespace App\Traits;

use DateTime;

trait CCNXHtmlParser
{

    /**
     * Mapping of column names to their respective values.
     *
     * @var array
     */
    private static $htmlColumns = [
        'event_date' => 'Date',
        'departure' => 'STD(Z)',
        'arrival' => 'STA(Z)',
        'check_in' => 'C/I(Z)',
        'check_out' => 'C/O(Z)',
        'activity' => 'Activity',
        'arrival_location' => 'From',
        'destination_location' => 'To',
        'ac_reg' => 'ACReg',
    ];

    /**
     * Parse table headers
     *
     * @var array
     */
    private function parseHtmlHeader($columns): array
    {
        $header = [];
        foreach ($columns as $column) {
            $header[] = trim($column->nodeValue);
        }

        return $header;
    }

    /**
     * Parse each row in the table
     *
     * @var array
     */
    private function parseHtmlRow($columns, $headers): array
    {
        $event = [];
        foreach ($headers as $index => $columnName) {
            $value = trim($columns->item($index)->nodeValue);
            $value = empty($value) ? null : $value;
            $this->parseHtmlEvent($columnName, $value, $event);
        }
        return $event;
    }


    /**
     * Parse a single roster event based on column name and value.
     *
     * @param string $columnName
     * @param string $value
     * @param array $event
     * @return void
     */
    public function parseHtmlEvent($columnName, $value, &$event)
    {
        $formattedDate = $this->getFormattedDate($value);

        match ($columnName) {
            self::$htmlColumns['event_date'] => $event['event_date'] = $formattedDate,
            self::$htmlColumns['departure'] => $event['departure'] = $this->createDateTime($event['event_date'], $value),
            self::$htmlColumns['arrival'] => $event['arrival'] = $this->createDateTime($event['event_date'], $value),
            self::$htmlColumns['check_in'] => $event['check_in'] = $this->createDateTime($event['event_date'], $value),
            self::$htmlColumns['check_out'] => $event['check_out'] = $this->createDateTime($event['event_date'], $value),
            self::$htmlColumns['activity'] => $event['activity'] = $value,
            self::$htmlColumns['arrival_location'] => $event['arrival_location'] = $value,
            self::$htmlColumns['destination_location'] => $event['destination_location'] = $value,
            self::$htmlColumns['ac_reg'] => $event['ac_reg'] = $value,
            default => null,
        };

        if($columnName == self::$htmlColumns['activity']){
            if (preg_match('/([A-Z]{2}\d+)/', $value, $matches)) {
                $event['flight_number'] = $matches[1];
                $event['event_type'] = 'FLT';  // Flight event type
            }else {
                $event['event_type'] = $value;
                $event['flight_number'] = null;
            }
        }
        
    }


    /**
     * Format the date based on the given value and assumed month and year.
     *
     * @param string $value
     * 
     * @return string|null
     */
    private function getFormattedDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }
        
        $assumedMonth = $this->startDate->format('m');
        $assumedYear = $this->startDate->format('Y');

        // Extract day and month from the value
        if(!preg_match('/([A-Za-z]+) (\d+)/', $value, $matches)){
            return null;
        }

        $dayName = $matches[1];
        $dayNumber = $matches[2];

        // Check if the day number is less than the start date's day number
        if ((int) $dayNumber < (int) $this->startDate->format('j')) {
            // Increment the assumed month
            $assumedMonth = $this->startDate->modify('+1 month')->format('m');
            $assumedYear = $this->startDate->format('Y');
        }

        $fullDate = DateTime::createFromFormat('D j m Y', $value . " {$assumedMonth} {$assumedYear}");

        return $fullDate ? $fullDate->format("Y-m-d") : null;
    }

    /**
     * Create a DateTime object based on the given date and time.
     *
     * @param string|null $date
     * @param string $time
     * @return DateTime|null
     */
    private function createDateTime($date, $time): ?String
    {
        if (!$date) {
            return null;
        }

        $dateTime = DateTime::createFromFormat('Y-m-d Hi', $date . ' ' . $time);

        return $dateTime ? $dateTime->format('Y-m-d H:i:s') :  null;
    }
}
