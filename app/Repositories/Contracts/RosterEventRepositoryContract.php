<?php


namespace App\Repositories\Contracts;


use App\Models\RosterEvent;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface RosterEventRepositoryContract
{

    /**
     * @param int $perPage
     * @param array $rel
     * @param string $sortDir
     * @param string|null $type
     * @param string|null $arrival
     * @param string|null $destination
     * @param string|null $metric
     * @param string|null $fromDate
     * @param string|null $toDate
     * @return CursorPaginator
     */
    public function getRosterEvents(
        int $perPage, 
        array $rel = [], 
        string $sortDir = 'asc', 
        ?string $type = null, 
        ?string $arrival = null, 
        ?string $destination = null, 
        ?string $metric = null,
        ?string $fromDate = null, 
        ?string $toDate = null
    ): CursorPaginator;
    
    /**
     * @param array $data
     * @return RosterEvent
     */
    public function storeRosterEvent(array $data): RosterEvent;
}
