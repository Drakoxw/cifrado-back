<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'plugin' => 'nullable|string',
            'idempresa' => 'required|numeric',
            'origen' => 'required|string',
            'destino' => 'required|string',
            'valorrecaudo' => 'required|numeric',
            'valorMinimo' => 'required|numeric',
            'idasumecosto' => 'required|numeric|between:0,1',
            'contraentrega' => 'required|between:0,1',
            'productos' => 'required|array',
            'productos.*.alto' => 'required|numeric',
            'productos.*.largo' => 'required|numeric',
            'productos.*.ancho' => 'required|numeric',
            'productos.*.peso' => 'required|numeric',
            'productos.*.nombre' => 'nullable|string',
            'productos.*.unidades' => 'required|numeric',
            'productos.*.valorDeclarado' => 'required|numeric',
            'token' => 'required|string',
        ];
    }
}
