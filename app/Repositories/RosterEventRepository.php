<?php


namespace App\Repositories;


use App\Models\RosterEvent;
use App\Repositories\Contracts\RosterEventRepositoryContract;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Recca0120\Repository\EloquentRepository;

class RosterEventRepository extends EloquentRepository implements RosterEventRepositoryContract
{
    public function __construct(RosterEvent $roster_event)
    {
        parent::__construct($roster_event);
    }

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
    final public function getRosterEvents(
        int $perPage, 
        array $rel = [], 
        string $sortDir = 'asc', 
        ?string $type = null, 
        ?string $arrival = null, 
        ?string $destination = null, 
        ?string $metric = null,
        ?string $fromDate = null, 
        ?string $toDate = null
    ): CursorPaginator
    {
        $query = $this->newQuery()->with($rel);

        $query->when(!empty($type), function ($q) use ($type) {
            return $q->where('event_type', $type);
        })->when(!empty($arrival), function ($q) use ($arrival) {
            return $q->where('arrival_location', $arrival);
        })->when(!empty($destination), function ($q) use ($destination) {
            return $q->where('destination_location', $destination);
        });
        
        return $query
            ->withMetricFilter($metric, $fromDate, $toDate)
            ->orderBy('id', $sortDir)
            ->cursorPaginate($perPage);
    }

    /**
     * @param array $data
     * @return RosterEvent
     */
    final public function storeRosterEvent(array $data): RosterEvent
    {   
        $data['uuid'] = generateUuid();
        
        $roster_event = RosterEvent::create($data);
        
        return $roster_event->refresh();
    }
}
