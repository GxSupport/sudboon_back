<?php


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

function throwErrors($errors, $code = 400)
{
    if (DB::transactionLevel()) DB::rollBack();
    throw new HttpResponseException(errors($errors, $code));
}

/**
 * @param $message
 * @param int $code
 * @throws HttpResponseException
 */
function throwError($message, int $code = 400)
{
    throwErrors(['errors' => [['message' => $message]]], $code);
}

function failedValidation($validator)
{
    $errors = [];
    foreach ($validator->errors()->toArray() as $key => $value) {
        $errors[] = ['message' => $value['0'] . " ($key)"];
    }
    throwErrors(['errors' => $errors]);
}

/* RESPONSE */

/**
 * Response JSON success
 */
function success($data = false): JsonResponse
{
    if ($data === false) $data = ['success' => 1];
    return response()->json($data);
}

function generateToken(int $length = 16):string
{
    return Str::random($length);
}

/**
 * Response JSON errors
 */
function errors($errors, int $code = 400): JsonResponse
{
    return response()->json($errors, $code);
}

/**
 * Response JSON error
 */
function error($message, int $code = 400): JsonResponse
{
    return errors(['errors' => [['message' => $message]]], $code);
}

