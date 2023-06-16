<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HttpResponse
{
    /**
     * Send a success response.
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public function success($data = null, ?string $message = null, int $status = Response::HTTP_OK, array $headers = [], int $options = 0): JsonResponse
    {
        $response = [
            'status' => true,
            'message' => $message ?? 'Success',
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $status, $headers, $options);
    }

    /**
     * Send an error response.
     *
     * @param string|null $message
     * @param mixed|null $errors
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public function error(?string $message = null, $errors = null, int $status = Response::HTTP_BAD_REQUEST, array $headers = [], int $options = 0): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message ?? 'Error',
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status, $headers, $options);
    }
}
