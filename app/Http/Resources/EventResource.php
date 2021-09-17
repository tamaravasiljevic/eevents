<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Event Resource",
 *     description="Event Resource info",
 *     @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="Id of event",
 *          example=14397942
 *     ),
 *     @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Event's name",
 *          example="My first event"
 *     ),
 *     @OA\Property(
 *          property="slug",
 *          type="string",
 *          description="Event's slug",
 *          example="my-first-event"
 *     ),
 *     @OA\Property(
 *          property="description",
 *          type="string",
 *          example="Our new event"
 *     ),
 *     @OA\Property(
 *         property="company",
 *         format="string"
 *     ),
 *     @OA\Property(
 *         property="venue",
 *         format="string"
 *     ),
 *     @OA\Property(
 *         property="starts_at",
 *         format="string"
 *     ),
 *     @OA\Property(
 *         property="ends_at",
 *         format="string"
 *     ),
 *     @OA\Property(
 *         property="capcity",
 *         format="integer",
 *         example=100
 *     ),
 *     @OA\Property(
 *         property="visibility",
 *         format="string",
 *         example="Draft",
 *     ),
 *     @OA\Property(
 *         property="status",
 *         format="string",
 *         example="Active",
 *     ),
 *     @OA\Property(
 *         property="event_type",
 *         format="string"
 *     ),
 * )
 */
class EventResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'description'   => strip_tags(html_entity_decode($this->description)),
            'company'       => $this->company->name ?? '',
            'venue'         => $this->venue->name ?? '',
            'starts_at'     => $this->starts_at ? Carbon::parse($this->starts_at)->toDateTimeString() : null,
            'ends_at'       => $this->starts_at ? Carbon::parse($this->ends_at)->toDateTimeString() : null,
            'capacity'      => (int) $this->total_capacity,
            'visibility'    => $this->visibility,
            'event_type'    => $this->eventType->name ?? ''
        ];
    }
}
