<?php
/**
 * Copyright ©Uniwizard All rights reserved.
 * See LICENSE_UNIWIZARD for license details.
 */
declare(strict_types=1);

namespace App\Common\CurrencyTranslator;

class AmountTranslator implements CurrencyTranslatorInterface
{
    /**
     * @param int|null    $base
     * @param float|null  $floatRepresetation
     * @param string|null $stringRepresetation
     *
     * @throws AmountException
     */
    public function __construct(
        private ?int $base = null,
        private ?float $floatRepresetation = null,
        private ?string $stringRepresetation = null
    )
    {
        if(!$this->isValidContructorParams([$base, $floatRepresetation, $stringRepresetation])) {
            throw new AmountException('Only one params needed: Base or FloatRepresetation or StringRepresetation');
        }

        if($base !== null && $floatRepresetation === null && $stringRepresetation === null) {
            $this->floatRepresetation = static::translateBaseToFloat($base);
        }
        elseif($base === null && $floatRepresetation !== null && $stringRepresetation === null) {
            $this->base = static::translateFloatToBase($floatRepresetation);
        } else {
            $this->base = static::translateFloatToBase(
                (float)str_replace(',', '.', $stringRepresetation)
            );
        }
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    private function isValidContructorParams(array $params): bool
    {
        $isExists = false;
        foreach($params as $param) {
            if($param !== null) {
                if($isExists) {
                    return false;
                }
                $isExists = true;
            }
        }

        return true;
    }

    /**
     * @return int
     */
    public function getBase(): int
    {
        return $this->base;
    }

    /**
     * @return float
     */
    public function getFloat(): float
    {
        return $this->floatRepresetation;
    }

    /**
     * @param int $positions
     *
     * @return string
     */
    public function getAmount(int $positions = 2): string
    {
        if($positions < 2) {
            $positions = 2;
        }
        $format = '%.' . $positions . 'f';

        return sprintf($format, $this->getFloat());
    }

    /**
     * @param int $base
     *
     * @return float
     */
    static public function translateBaseToFloat(int $base): float
    {
        return (float)($base / 100);
    }

    /**
     * @param float $floatRepresetation
     *
     * @return int
     */
    static public function translateFloatToBase(float $floatRepresetation): int
    {
        return (int)($floatRepresetation * 100);
    }
}
