<?php

namespace App\Traits\Models;

use Carbon\Carbon;

trait HasMetrics
{
    private $today;

    public function scopeToday($query)
    {
        return $query->whereBetween('event_date', [$this->today->copy()->startOfDay(), $this->today->copy()->endOfDay()]);
    }

    public function scopeWeek($query)
    {
        return $query->whereBetween('event_date', [$this->today->copy()->startOfWeek(), $this->today->copy()->endOfWeek()]);
    }

    public function scopeNextWeek($query)
    {
        return $query->whereBetween('event_date', [$this->today->copy()->addWeek()->startOfWeek(), $this->today->copy()->addWeek()->endOfWeek()]);
    }

    public function scopeMonth($query)
    {
        return $query->whereBetween('event_date', [$this->today->copy()->startOfMonth(), $this->today->copy()->endOfMonth()]);
    }

    public function scopeLast30Days($query)
    {
        return $query->whereBetween('event_date', [$this->today->copy()->subDays(30), $this->today->copy()]);
    }

    public function scopeLast90Days($query)
    {
        return $query->whereBetween('event_date', [$this->today->copy()->subDays(90), $this->today->copy()]);
    }

    public function scopeCurrentYear($query)
    {
        return $query->whereBetween('event_date', [$this->today->copy()->startOfYear(), $this->today->copy()->endOfYear()]);
    }

    public function scopeCustomDateRange($query, $fromDate, $toDate)
    {
        $from = Carbon::createFromFormat('m/d/Y', $fromDate);
        $to = Carbon::createFromFormat('m/d/Y', $toDate);

        return $query->whereBetween('event_date', [$from->startOfDay(), $to->endOfDay()]);
    }

    public function scopeWithMetricFilter($query, $metric, $fromDate = null, $toDate = null)
    {
        $this->today  = Carbon::createFromFormat("m/d/Y", "01/14/2022");

        return match ($metric) {
            'today' => $query->today(),
            'week' => $query->week(),
            'nextWeek' => $query->nextWeek(),
            'month' => $query->month(),
            '30days' => $query->last30Days(),
            '90days' => $query->last90Days(),
            'year' => $query->currentYear(),
            'allyear' => $query,
            'custom' => $query->customDateRange($fromDate, $toDate),
            default => $query,
        };
    }
}
