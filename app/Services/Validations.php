<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class Validations
{

    private static function makeValidator(Request $request, $rulesValidator): \Illuminate\Validation\Validator
    {
        $validator = Validator::make($request->all(), $rulesValidator);

        if (count($validator->errors()) > 0) {
            throw new Exception(
                'SerializedError::' . serialize($validator->errors()->messages()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $validator;
    }

    public static function SearchPrefix(Request $request): \Illuminate\Validation\Validator
    { // {"tipo":"listar","code":"US"}
        return self::makeValidator($request, [
            'tipo'     => ['required', 'string'],
            'code'    => ['required', 'numeric', 'min:1', 'max:5'],
        ]);
    }

    public static function ContactMe(Request $request): \Illuminate\Validation\Validator
    {
        return self::makeValidator($request, [
            'fullname' => ['required', 'string', 'max:255', 'min:3'],
            'email'    => ['required', 'email'],
            'phone'    => ['required', 'numeric'],
            'subject'  => ['required', 'string', 'max:255', 'min:3'],
            'message'  => ['required', 'string', 'max:1555', 'min:3'],
        ]);
    }

    public static function TestEmail(Request $request): \Illuminate\Validation\Validator
    {
        return self::makeValidator($request, [
            'email'    => ['required', 'email'],
        ]);
    }

    public static function UserLogin(Request $request): \Illuminate\Validation\Validator
    {
        return self::makeValidator($request, [
            'user'    => ['required', 'string'],
            'pass'    => ['required', 'string'],
        ]);
    }

    public static function AdminImages(Request $request)
    {
        $valid = self::makeValidator($request, [
            'action'    => ['required', 'string', 'in:delete,update'],
            'path'      => ['required', 'string'],
            'base64'    => ['nullable', 'string', Rule::when(fn ($input) => $input->action == 'update', ['required', 'string', 'min:100'])],
            'mimeType'  => ['nullable', 'string', Rule::when(fn ($input) => $input->action == 'update', ['required', 'string', 'min:5'])],
        ]);

        if (!in_array($request->mimeType, ['image/jpeg','image/png','image/gif', 'image/webp'])) {
            throw new Exception("Formato de imagen no permitido", 406);
        }

        return $valid;
    }

    public static function SaveAssets(Request $request): \Illuminate\Validation\Validator
    {
        $valid = self::makeValidator($request, [
            'base64'    => ['required', 'string'],
            'nameFile'  => ['required', 'string'],
            'mimeType'  => ['required', 'string'],
        ]);

        if (!in_array($request->mimeType, ['image/jpeg','image/png','image/gif', 'image/webp'])) {
            throw new Exception("Formato de imagen no permitido", 406);
        }

        return $valid;
    }
}
