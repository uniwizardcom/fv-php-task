<?php
/**
 * Copyright ©Uniwizard All rights reserved.
 * See LICENSE_UNIWIZARD for license details.
 */
declare(strict_types=1);


namespace App\Common;


trait UserIsActiveInoutParameterTrait
{
    public function parseArgIsActive($isActive): ?bool
    {
        if($isActive === true || $isActive === false) {
            return $isActive;
        }
        elseif($isActive === 'true') {
            return true;
        }
        elseif($isActive === 'false') {
            return false;
        }
        else if($isActive !== null) {
            return (bool)$isActive;
        }

        return null;
    }
}