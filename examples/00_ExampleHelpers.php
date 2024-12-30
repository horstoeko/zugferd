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

/**
 * Outputs a line to CLI. It uses sprintf.
 *
 * @param string $message
 * @param mixed ...$args
 * @return void
 */
function writeLnToCli(string $message, ...$args): void
{
    $output = sprintf($message, ...$args);

    if (trim($output) !== '' && trim($output) !== '0') {
        echo $output . PHP_EOL;
    }
}

/**
 * Write an empty line to CLI
 *
 * @return void
 */
function writeNewLineToCli(): void
{
    echo PHP_EOL;
}

/**
 * Implode an associative array to form key=value
 *
 * @param string $separator
 * @param array $array
 * @return string
 */
function implodeAssocArray(string $separator, array $array): string
{
    return
        implode(
            $separator,
            array_map(function ($key, $value) {
                return sprintf("%s=%s", $key, $value);
            }, array_keys($array), $array)
        );
}
