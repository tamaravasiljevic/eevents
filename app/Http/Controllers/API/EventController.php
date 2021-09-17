<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
/**
 * @OA\Info(
 *     title="Eevents API",
 *     version="1.0.0"
 *      )
 */
class EventController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/events/create",
     *      tags={"Events"},
     *      description="Create new event",
     *      security={ {"bearer": {}} },
     *      @OA\RequestBody(
     *          description="Create new event",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      format="string",
     *                      example="My first event"
     *                  ),
     *                  @OA\Property(
     *                      property="slug",
     *                      format="string",
     *                      example="my-first-event"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      format="text",
     *                      example="Description for my first event"
     *                  ),
     *                  @OA\Property(
     *                      property="company_id",
     *                      format="inetger"
     *                  ),
     *                  @OA\Property(
     *                      property="venue_id",
     *                      format="inetger"
     *                  ),
     *                  @OA\Property(
     *                      property="starts_at",
     *                      format="date"
     *                  ),
     *                  @OA\Property(
     *                      property="ends_at",
     *                      format="date"
     *                  ),
     *                  @OA\Property(
     *                      property="capcity",
     *                      format="integer",
     *                      example=100
     *                  ),
     *                  @OA\Property(
     *                      property="visibility",
     *                      format="string",
     *                      example="Draft",
     *                  ),
     *                  @OA\Property(
     *                      property="status",
     *                      format="string",
     *                      example="Active",
     *                  ),
     *                  @OA\Property(
     *                      property="event_type_id",
     *                      format="inetger"
     *                  ),
     *                  required={"name", "slug", "description",},
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                   ref="#/components/schemas/Event Resource"
     *              )
     *          )
     *      ),
     *      @OA\Response(response=403, description="Unauthorized"),
     *      @OA\Response(response=422, description="Validation failed"),
     * )
     */
    public function store(EventRequest $request)
    {
        $user   = Auth::guard('api')->user();

        try {
            \DB::beginTransaction();

            $event  = Event::create([
                'name' => $request->get('name'),
                'slug' => $request->get('slug'),
            ]);


        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        \DB::commit();

        return new EventResource($event);
    }

    /**
     * @OA\Get(
     *     path="/api/events/{id}",
     *     tags={"Events"},
     *     description="Returns details for event fetched by id",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          example="61421730c8a020255758a5d7",
     *          description="Id of event",
     *          required=true,
     *          @OA\Schema(type="string"),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  description="Event data",
     *                  type="object",
     *                  ref="#/components/schemas/Event Resource"
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response=404, description="Model not found"),
     * )
     */
    public function show($id)
    {
        $event  = Event::find($id);

        if (!$event) {

        }

        return new EventResource($event);
    }
}
