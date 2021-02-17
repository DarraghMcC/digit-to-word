<?php

namespace App\Http\Controllers;

use App\Services\Convertor as ConvertorService;
use Illuminate\Http\Request;

class Convertor extends Controller
{

    protected $convertorService;

    public function __construct(ConvertorService $convertorService)
    {
        $this->convertorService = $convertorService;
    }

    public function convertAmountToWords(Request $request, $value)
    {
        if (!$this->convertorService->isValueValid($value)) {
            return response()->json([
                'error' => 'Defined value must be a dollar amount between '
                . ConvertorService::MIN_VALUE . ' and ' . ConvertorService::MAX_VALUE
                . ' with an optional decimal place precision of '
                . ConvertorService::REQUIRED_PRECISION ,
            ], 400);
        }

        $convertedValue = $this->convertorService->convertAmountToWords($value);

        return ['convertedValue' => $convertedValue];
    }
}
