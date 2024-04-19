<?php

namespace App\Http\Controllers\Api\RosterEvent;

use App\Http\Controllers\Controller;
use App\Http\Requests\RosterEvent\QueryRosterEventRequest;
use App\Http\Requests\RosterEvent\StoreRosterEventRequest;
use App\Http\Resources\RosterEventResource;
use App\Interfaces\RosterParserInterface;
use App\Repositories\Contracts\RosterEventRepositoryContract;
use App\Traits\HasApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * @group Roster Event Api
 *
 * This allows access to manage roster events
 *
 *
 * Class RosterEventController
 *
 * @package App\Http\Controllers\Api\RosterEvent
 */
class RosterEventController extends Controller
{
    use HasApiResponse;

    public function __construct(
        public readonly RosterEventRepositoryContract $rosterEventRepository, 
    ){}

    /**
     * Get Roster Events
     *
     * This allows roster_events to view the paginated data of roster_events
     *
     * @responseFile status=200 storage/responses/roster_event/index.json
     *
     * @param QueryRosterEventRequest $request
     *
     * @return JsonResponse
     */
    final public function index(QueryRosterEventRequest $request): JsonResponse
    {
        $data = $request->validated();

        $events = $this->rosterEventRepository->getRosterEvents(
            $data['per_page'] ?? 100,
            [],
            $data['sort_dir'] ?? 'asc',
            $data['type'] ?? null,
            $data['arrival_location'] ?? null,
            $data['destination_location'] ?? null,
            $data['metrics'] ?? null,
            $data['from_date'] ?? null,
            $data['to_date'] ?? null,
        );

        return $this->sendResponse(
            RosterEventResource::collection($events->appends($data))
                ->response()
                ->getData(true)
        );
    }

    /**
     * Upload Roster Events
     *
     * This allows upload of roster to be parsed
     *
     * @responseFile status=200 storage/responses/roster_event/upload.json
     *
     * @param StoreRosterEventRequest $request
     *
     * @return JsonResponse
     */
    final public function uploadRoster(StoreRosterEventRequest $request, RosterParserInterface $roasterService): JsonResponse
    {
        $file = $request->file('roster');
        try {
            $events = $roasterService->parseFile($file);
            foreach($events as $event){
                $this->rosterEventRepository->storeRosterEvent($event);
            }
        } catch (Exception $th) {
            Log::info($th->getMessage(), formatExceptionContext($th));
            return $this->sendError("An error occurred trying to parse file");
        }
       

        return $this->sendSuccess("Roster Parsed Succefully");
    }
}
