<?php

namespace App\Services\DisplayParsing;

class TesseractParser {
    /**
     * @param string $tsvOutput
     * @return TesseractResults
     */
    public static function parse(string $tsvOutput): TesseractResults
    {
        $results = [];
        $lines = explode("\n", $tsvOutput);

        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }

            $data = explode("\t", $line);
            $data = array_map('trim', $data);

            // Skipping header row
            if ($data[0] === 'level') {
                continue;
            }

            // Skipping empty text
            if (empty($data[11])) {
                continue;
            }

            $results[] = TesseractDetection::make()
                ->setLevel($data[0])
                ->setPageNum($data[1])
                ->setBlockNum($data[2])
                ->setParNum($data[3])
                ->setLineNum($data[4])
                ->setWordNum($data[5])
                ->setLeft($data[6])
                ->setTop($data[7])
                ->setWidth($data[8])
                ->setHeight($data[9])
                ->setConf($data[10])
                ->setText($data[11]);
        }

        return new TesseractResults($results);
    }
}
