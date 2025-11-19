<?php

namespace App\Services\DisplayParsing;

class TesseractResults {
    /** @var TesseractDetection[] */
    public array $detections = [];

    public function __construct(array $detections)
    {
        $this->detections = $detections;
    }

    public function isEmpty(): bool
    {
        return empty($this->detections);
    }

    public function filterByConfidence(int $minConfidence): self
    {
        $this->detections = array_filter($this->detections, fn($detection) => $detection->conf >= $minConfidence);

        return $this;
    }

    /**
     * @param string $text
     * @return TesseractDetection[]
     */
    public function findByText(string $text): array
    {
        return array_filter($this->detections, fn($detection) => $detection->text === $text);
    }
}
