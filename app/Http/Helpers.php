<?php

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

if( !function_exists('carbonParse') )
{
    /**
     * @param string $dateTime
     * @param string|null $timezone
     * @return Carbon
     */
    function carbonParse(string $dateTime, string $timezone = null): Carbon
    {
        $instance = $timezone ?
            Carbon::parse($dateTime)->timezone($timezone) :
            Carbon::parse($dateTime);

        if (!$timezone && $instance->timezoneName !== DEFAULT_APP_TIMEZONE)
            $instance = $instance->timezone(DEFAULT_APP_TIMEZONE);

        return $instance;
    }
}

if( !function_exists('parseRequestTime') )
{
    /**
     * @param string|null $dateTime
     * @return ?Carbon
     */
    function parseRequestTime(string|null $dateTime): ?Carbon
    {
        if(!$dateTime) return null;

        $timezone = DEFAULT_APP_TIMEZONE;
        return Carbon::parse($dateTime)->timezone($timezone);
    }
}

if( !function_exists('valueFromPercent') )
{
    /**
     * @param float|int $percentage
     * @param float|int $totalValue
     * @return float|int
     */
    function valueFromPercent($percentage, $totalValue)
    {
        return ($percentage * $totalValue) / 100;
    }
}

if( !function_exists('slugger') )
{
    /**
     * @param string $text
     * @param string $suffix
     * @return string
     */
    function slugger(string $text, string $suffix = ''): string
    {
        return Str::slug("$text $suffix");
    }
}

if( !function_exists('generateUuid') )
{
    /**
     * @return string
     */
    function generateUuid(): string
    {
        return Str::orderedUuid()->toString();
    }
}

if( !function_exists('convertToBoolean') )
{
    /**
     * @param string|bool $data
     * @return bool
     */
    function convertToBoolean($data): bool
    {
        if(is_bool($data)) return $data;

        if($data === 'false') return false;

        return (bool)$data;
    }
}

if( !function_exists('formatExceptionContext') )
{
    /**
     * @param Exception $exception
     * @param array $data
     * @return array
     */
    function formatExceptionContext(Exception $exception, array $data = []): array
    {
        return array_merge([
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ], $data);
    }
}

if( !function_exists('isValidTimezone') )
{
    /**
     * @param string $timezone
     * @return bool
     */
    function isValidTimezone(string $timezone): bool
    {
        return in_array($timezone, timezone_identifiers_list());
    }
}

if( !function_exists('isBase64Image') )
{
    /**
     * @param string $image
     * @return bool
     */
    function isBase64Image(string $image): bool
    {
        $data = explode('/', $image);
        return !empty($data[0]) && str_contains($data[0], 'image');
    }
}
