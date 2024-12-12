<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *     title="Facchas",
 *     version="1.0.0",
 *     description="Sistema de administración deportiva."
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected function sendResponse($result, $message, $type = 'success', $code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $result,
            'type' => $type
        ], $code);
    }

    protected function sendError($error, $code = 500, $type = 'error')
    {
        return response()->json([
            'message' => $error,
            'type' => $type
        ], $code);
    }
}
