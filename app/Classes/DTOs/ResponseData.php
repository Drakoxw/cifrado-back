<?php

namespace App\Classes\DTOs;

class ResponseData {
    public bool $success;
    public string $message;
    public $data;

    public function __construct(bool $success, string $message, $data) {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }

    public function isSuccess() {
        return $this->success;
    }

    public function __toString() {
        return $this->toJson();
    }

    public function toArray() {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data
        ];
    }

    public function toJson() {
        return json_encode($this->toArray());
    }

    public function toXml() {
        return xmlrpc_encode($this->toArray());
    }

    public function toHtml() {
        return '<pre>' . print_r($this->toArray(), true) . '</pre>';
    }

    public function toText() {
        return $this->toArray();
    }

    public function toBinary() {
        return xmlrpc_encode($this->toArray());
    }

    public function toBase64() {
        return base64_encode($this->toJson());
    }
}
