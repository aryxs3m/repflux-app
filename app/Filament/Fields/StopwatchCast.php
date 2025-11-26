<?php

namespace App\Filament\Fields;

use Filament\Schemas\Components\StateCasts\Contracts\StateCast;
use LogicException;

/**
 * There is probably a better way to do this. Feel free to send a pull request :)
 */
final class StopwatchCast implements StateCast
{
    public static function format(mixed $state): string
    {
        return (new self)->set($state);
    }

    public function get(mixed $state): ?int
    {
        if (empty($state)) {
            return null;
        }

        $parts = explode(':', $state);

        if (count($parts) !== 3) {
            throw new LogicException('Invalid time format. Valid format has 3 : symbols (00:00:00.000).');
        }

        $hours = (int) $parts[0];
        $minutes = (int) $parts[1];

        $secondsMilliseconds = explode('.', $parts[2]);

        if (count($secondsMilliseconds) !== 2) {
            throw new LogicException('Invalid time format: missing milliseconds. Valid format: 00:00:00.000');
        }

        $seconds = (int) $secondsMilliseconds[0];
        $milliseconds = (int) $secondsMilliseconds[1];

        return $milliseconds + ($seconds * 1000) + ($minutes * 60000) + ($hours * 3600000);
    }

    public function set($state): string
    {
        if ($state === null) {
            return '00:00:00.000';
        }

        if (! is_int($state)) {
            throw new LogicException('Invalid state type. Expected int.');
        }

        if ($state < 0) {
            throw new LogicException('Invalid state value. Expected positive integer.');
        }

        $carry = $state;
        $hours = $carry / 3600000;
        $carry %= 3600000;

        $minutes = $carry / 60000;
        $carry %= 60000;

        $seconds = $carry / 1000;
        $milliseconds = $carry % 1000;

        return sprintf('%02d:%02d:%02d.%03d', $hours, $minutes, $seconds, $milliseconds);
    }
}
