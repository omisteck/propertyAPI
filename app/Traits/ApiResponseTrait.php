<?php
namespace App\Traits;

trait ApiResponseTrait
{
    public function JsonResponse(
         $data, string $message ="Request Successful!", int $status = 200, array $header = []
        )
    {
        return response()->json(
            [
                "code" => $status,
                "message" => $message,
                "data" => $data
            ],
            $status,
            $header
        );
    }

    public function successResponse(
        $data, $message, $status
    ){
        return $this->JsonResponse($data, $message, $status);
    }
}
