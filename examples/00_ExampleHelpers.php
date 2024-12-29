<?php

use horstoeko\zugferd\ZugferdDocument;
use horstoeko\zugferd\ZugferdKositValidator;

/**
 * Enable/Disable example remote validation against the KOSiT-Validator.
 *
 * @return boolean
 */
function validationEnabled(): bool
{
    return true;
}

/**
 * Get the remote host (name or IP) where the KOSiT validator is running in daemon mode.
 *
 * @return string
 */
function getKositValidatorRemoteHost(): string
{
    return "127.0.0.1";
}

/**
 * Get the remote port of the machine where the KOSiT validator is running in daemon mode.
 *
 * @return integer
 */
function getKositValidatorRemotePort(): int
{
    return 8081;
}

/**
 * Helper functiom for validation using KOSiT-Validator.
 * Returns the following values
 * - 0 = Validation is disabled
 * - 1 = Validation was successfull
 * - 2 = Validation was not successfull
 *
 * @param  ZugferdDocument $zugferdDocument
 * @return int
 */
function validateUsingKositValidator(ZugferdDocument $zugferdDocument): int
{
    if (!validationEnabled()) {
        return 0;
    }

    $kositValidator = new ZugferdKositValidator();
    $kositValidator->setDocument($zugferdDocument);
    $kositValidator->enableRemoteMode();
    $kositValidator->setRemoteModeHost(getKositValidatorRemoteHost());
    $kositValidator->setRemoteModePort(getKositValidatorRemotePort());
    $kositValidator->validate();

    return $kositValidator->hasNoValidationErrors() ? 1 : 2;
}