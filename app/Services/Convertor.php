<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;

class Convertor
{
    public const MIN_VALUE = 0.00;
    public const MAX_VALUE = 1000.00;
    public const REQUIRED_PRECISION = 2;

    // these array indexes match relevant values
    // I.E. index 1 -> 11, 3 -> thirty etc
    // we leave 0 as empty here as we do not want to treat this as no value
    private $singleDigits = array('', 'One', 'Two', 'Three', 'Four', 'Five',
        'Six', 'Seven', 'Eight', 'Nine');
    private $teens = array('Ten', 'Eleven', 'Twelve', 'Thirteen',
        'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen ');
    private $mutiplesOfTen = array('', 'Ten', 'Twenty', 'Thirty', 'Forty',
        'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety');

    public function isValueValid($value): bool
    {
        // is it a number
        if (!is_numeric($value)) {
            log::info('Supplied value is not numeric');
            return false;
        } 

        // is it within our defined bounds
        $converted_val = floatval($value);

        if ($converted_val < self::MIN_VALUE || $converted_val > self::MAX_VALUE) {
            log::info('Supplied value is outside limit bounds');
            return false;
        }

        // if has a decimal point, must have exact precision
        if (str_contains($value, '.') && strlen(explode('.', $value)[1]) != self::REQUIRED_PRECISION) {
            log::info('Supplied value has invalid decimal precision');
            return false;
        }

        return true;
    }

    public function convertAmountToWords($value): string
    {
        if (!$this->isValueValid($value)) {
            log::error('Invalid value passed to convert method');
            return 'Unconvertable Value';
        }

        // fast exit for zero
        if ((float) $value == 0) {
            log::debug('Zero value received');
            return 'Zero Dollars';
        }

        $splitValues = explode('.', $value); //split dollars from cents
        $valueInWords = $this->getDollarValue(intval($splitValues[0]));
        $centValue = '';

        if (count($splitValues) > 1) { //do we have any cent value
            $centValue = $this->getCentValue(intval($splitValues[1]));
        }

        // if we have cents and dollars we need an 'and'
        if ($valueInWords != '' && $centValue != '') {
            $valueInWords .= ' and ';
        }

        return $valueInWords . $centValue;

    }

    private function getCentValue(int $value): string
    {
        $centInWords = $this->numberToWords($value);

        if ($centInWords == '') { // no cents to add
            log::debug('Zero cent value defined');
            return '';
        }

        if ($centInWords == 'One') {
            return $centInWords . ' Cent'; // single cent when only one
        } else {
            return $centInWords . ' Cents';
        }
    }

    private function getDollarValue(int $value): string
    {
        $valueInWords = $this->getMultiplierValueInWords(((int) ($value / 1000) % 100), 'Thousand');

        $valueInWords .= $this->getMultiplierValueInWords(((int) ($value / 100) % 10), 'Hundred');

        // once we got over 100 and we have other values, we need an 'and'
        if ($value > 100 && $value % 100) {
            $valueInWords .= ' and ';
        }

        // less than 100 values (no "multiplier")
        $valueInWords .= $this->numberToWords(($value % 100));

        if ($valueInWords == '') {
            return $valueInWords; // if no value at all, no need for the 'Dollar' value
        }

        if ($valueInWords == 'One') {
            return $valueInWords . ' Dollar'; // single dollar when only one
        } else {
            return $valueInWords . ' Dollars';
        }
    }

    private function getMultiplierValueInWords(float $value, string $multiplerName): string
    {
        $convertedVal = $this->numberToWords($value);

        if ($convertedVal != '') { // has a multiplier to add
            return $convertedVal . ' ' . $multiplerName;
        }

        return '';
    }

    private function numberToWords(int $value)
    {
        switch (true) {
            case $value < 10: // 1-9
                return $this->singleDigits[$value];
            case $value < 19:// those pesky teens
                return $this->teens[$value % 10];
            case $value > 19: // 20 +
                $valueString = $this->mutiplesOfTen[(float) ($value / 10)];
                if ($value % 10 > 0) {
                    $valueString .= ' ' . $this->numberToWords($value % 10);
                }
                return $valueString;
            default: // shouldn't happen, but being safe
                log::warn('Number conversion fallen to default value');
                return 'Zero';
        }
    }
}
