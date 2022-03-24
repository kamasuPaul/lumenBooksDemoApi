<?php

namespace App\Http;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

trait ResponseTrait
{

    protected function respondWithCustomData($data, $status = 200): JsonResponse
    {
        return new JsonResponse([
            'data' => $data,
            'meta' => ['timestamp' => $this->getTimestampInMilliseconds()],
        ], $status);
    }

    /**
     * Return no content for delete requests
     */
    protected function respondWithNoContent(): JsonResponse
    {
        return new JsonResponse([
            'data' => null,
            'meta' => ['timestamp' => $this->getTimestampInMilliseconds()],
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Return collection response from the application
     */
    protected function respondWithCollection(LengthAwarePaginator $collection, $meta=[], $status = 200)
    {
        $fb = (object)[];
        $myarray = $collection->toArray();
        $links = (object)$meta;
        $links->from = $myarray['from'];
        $links->to = $myarray['to'];
        $links->per_page = $myarray['per_page'];
        $links->current_page = $myarray['current_page'];
        $links->last_page = $myarray['last_page'];
        $links->total = $myarray['total'];
        $fb->data = $myarray['data'];
        $fb->meta = $links;
        return new JsonResponse($fb,$status);
    }

    protected function fail($param, $message){
        throw ValidationException::withMessages([$param => $message]);
    }
}
