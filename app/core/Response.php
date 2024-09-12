<?php

class Response{
    public static function success($data = [], $message){
        echo json_encode([
            'data' => $data,
            'message' => $message ?? 'ok',
            'success' => true
        ]);
        die();
    }

    public static function fail($data = [], $message){
        echo json_encode([
            'data' => $data,
            'message' => $message ?? 'fail',
            'success' => false
        ]);
        die();
    }
}