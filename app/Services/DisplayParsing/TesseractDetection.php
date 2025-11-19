<?php

namespace App\Services\DisplayParsing;

class TesseractDetection {
    public int $level;
    public int $page_num;
    public int $block_num;
    public int $par_num;
    public int $line_num;
    public int $word_num;
    public int $left;
    public int $top;
    public int $width;
    public int $height;
    public float $conf;
    public string $text;

    public static function make(): TesseractDetection
    {
        return new self();
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): TesseractDetection
    {
        $this->level = $level;
        return $this;
    }

    public function getPageNum(): int
    {
        return $this->page_num;
    }

    public function setPageNum(int $page_num): TesseractDetection
    {
        $this->page_num = $page_num;
        return $this;
    }

    public function getBlockNum(): int
    {
        return $this->block_num;
    }

    public function setBlockNum(int $block_num): TesseractDetection
    {
        $this->block_num = $block_num;
        return $this;
    }

    public function getParNum(): int
    {
        return $this->par_num;
    }

    public function setParNum(int $par_num): TesseractDetection
    {
        $this->par_num = $par_num;
        return $this;
    }

    public function getLineNum(): int
    {
        return $this->line_num;
    }

    public function setLineNum(int $line_num): TesseractDetection
    {
        $this->line_num = $line_num;
        return $this;
    }

    public function getWordNum(): int
    {
        return $this->word_num;
    }

    public function setWordNum(int $word_num): TesseractDetection
    {
        $this->word_num = $word_num;
        return $this;
    }

    public function getLeft(): int
    {
        return $this->left;
    }

    public function setLeft(int $left): TesseractDetection
    {
        $this->left = $left;
        return $this;
    }

    public function getTop(): int
    {
        return $this->top;
    }

    public function setTop(int $top): TesseractDetection
    {
        $this->top = $top;
        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): TesseractDetection
    {
        $this->width = $width;
        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): TesseractDetection
    {
        $this->height = $height;
        return $this;
    }

    public function getConf(): float
    {
        return $this->conf;
    }

    public function setConf(float $conf): TesseractDetection
    {
        $this->conf = $conf;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): TesseractDetection
    {
        $this->text = $text;
        return $this;
    }
}
