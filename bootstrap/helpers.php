<?php

use Illuminate\Support\Facades\Log;

/**
 * Custom logging message format (includes component name)
 *
 * @param string $message the log message
 * @param string $component the name of the component
 *
 * @return string the formatted custom log message
 */
function formatLogMessage(string $message, string $component = 'dashboard')
{
    return \sprintf('[%s] %s', \strtoupper(\substr($component, \strpos($component, ':') + 1)), $message);
}

/**
 * Convert some Markdown text to HTML
 *
 * In case an exception occurs, the original text is returned.
 *
 * @param string $text the Markdown text to be converted
 *
 * @return string the converted HTML text
 */
function markdown($text)
{
    try {
        return (new ParsedownExtra)->text($text);
    } catch (Exception $e) {
        Log::error($e->getMessage());
        return $text;
    }
}