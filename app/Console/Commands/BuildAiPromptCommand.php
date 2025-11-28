<?php

namespace App\Console\Commands;

use App\Filament\Resources\RecordTypeResource\CardioMeasurement;
use App\Filament\Resources\RecordTypeResource\CardioMeasurementType;
use Illuminate\Console\Command;

class BuildAiPromptCommand extends Command{
    protected $signature = 'build:ai-prompt';

    protected $description = 'Command description';

    public function handle(): void
    {
        $prompt =  "Your job is to detect and parse information from photos of fitness machine displays. ";
        $prompt .= "You are only allowed to reply in JSON, and the only allowed keys are: ";

        $cases = [];
        foreach (CardioMeasurement::cases() as $case) {
            $cases[] = sprintf(
                '%s (%s %s)',
                $case->getFieldName(),
                empty($case->getMeasurementUnit()) ? 'N/A' : $case->getMeasurementUnit(),
                $case->getMeasurementType()->name);
        }

        $prompt .= implode(', ', $cases) . '.';
        $prompt .= ' Only send raw numbers, no units. Time is measured in minutes, rounded to the nearest.';
        $prompt .= ' I send you two example photos with the expected output and an explanation.';

        $this->line($prompt);
    }
}
