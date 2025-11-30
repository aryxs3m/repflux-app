<?php

use App\Services\Gamification\GamifiedSize;

it('can show nothing', function () {
    $this->assertEquals('Nothing', GamifiedSize::get(0));
});

it('can show sm values', function () {
    $result = GamifiedSize::get(1);

    $this->assertNotEmpty($result);
    $this->assertStringContainsString(' ', $result);
    $this->assertIsNotNumeric($result);
});

it('can show m values', function () {
    $result = GamifiedSize::get(1000);

    $this->assertNotEmpty($result);
    $this->assertStringContainsString(' ', $result);
    $this->assertIsNotNumeric($result);
});

it('can show lg values', function () {
    $result = GamifiedSize::get(10000);

    $this->assertNotEmpty($result);
    $this->assertStringContainsString(' ', $result);
    $this->assertIsNotNumeric($result);
});

it('can show xl values', function () {
    $result = GamifiedSize::get(100000);

    $this->assertNotEmpty($result);
    $this->assertStringContainsString(' ', $result);
    $this->assertIsNotNumeric($result);
});

it('can show very 2xl values', function () {
    $result = GamifiedSize::get(1000000);

    $this->assertNotEmpty($result);
    $this->assertStringContainsString(' ', $result);
    $this->assertIsNotNumeric($result);
});

it('can show very 4xl values', function () {
    $result = GamifiedSize::get(100000000);

    $this->assertNotEmpty($result);
    $this->assertStringContainsString(' ', $result);
    $this->assertIsNotNumeric($result);
});
