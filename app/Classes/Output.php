<?php

namespace App\Classes;

class Output
{

    public static function success($messageOrData, $data = null)
    {
        $response = [
            'status' => 'success'
        ];

        if (!empty($messageOrData) && !is_array($messageOrData)) {
            $response['message'] = Output::getTranslated($messageOrData);
        }

        if (is_array($data)){
            $response = array_merge($data, $response);
        }

        if (is_array($messageOrData)) {
            $response = array_merge($messageOrData, $response);
        }

        return $response;
    }

    public static function error($message, $errorName = null, $errorData = [])
    {
        return response([
            'status' => 'fail',
            'error_name' => $errorName,
            'data' => $errorData,
            'message' => Output::getTranslated($message)
        ], 422);
    }

    public static function formErrors($validator)
    {
        return [
            'status' => 'fail',
            'errors' => $validator->getMessageBag()->toArray(),
            'message' => 'Please make sure to fill all the necessary fields.'
        ];
    }

    public static function redirect($url, $message = null)
    {
        if ($message) {
            return [
                'status' => 'success',
                'message' => Output::getTranslated($message),
                'action' => 'redirect',
                'url' => $url
            ];
        }
        else {
            return [
                'status' => 'success',
                'action' => 'redirect',
                'url' => $url
            ];
        }
    }

    private static function getTranslated($message)
    {
        $trans = trans($message);

        if ($trans == $message) {
            return $message;
        }
        else {
            return $trans;
        }
    }

    public static function dataOnly($data)
    {
        return $data;
    }

    public static function successWithData($data)
    {
        $response = [
            'status' => 'success'
        ];

        $response['data'] = $data;

        return $response;
    }

}