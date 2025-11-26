<?php

use App\Filament\Fields\StopwatchCast;

// Getter tests

it('can get 0 from default time', function () {
    $cast = new StopwatchCast;
    $this->assertEquals(0, $cast->get('00:00:00.000'));
});

it('gets an exception from invalid time', function () {
    $cast = new StopwatchCast;
    $this->expectException(LogicException::class);
    $cast->get('invalid');
});

it('can get 0 from NULL time', function () {
    $cast = new StopwatchCast;
    $this->assertEquals(0, $cast->get(null));
});

it('can get 0 from empty time', function () {
    $cast = new StopwatchCast;
    $this->assertEquals(0, $cast->get(''));
});

it('can get 1000 ms from 1 second', function () {
    $cast = new StopwatchCast;
    $this->assertEquals(1000, $cast->get('00:00:01.000'));
});

it('can get 60000 ms from 1 minute', function () {
    $cast = new StopwatchCast;
    $this->assertEquals(60000, $cast->get('00:01:00.000'));
});

// Setter tests

it('can set 0 to default time', function () {
    $cast = new StopwatchCast;
    $this->assertEquals('00:00:00.000', $cast->set(0));
});

it('can set 1000 to 00:00:01.000 time', function () {
    $cast = new StopwatchCast;
    $this->assertEquals('00:00:01.000', $cast->set(1000));
});

it('can set 60000 to 00:01:00.000 time', function () {
    $cast = new StopwatchCast;
    $this->assertEquals('00:01:00.000', $cast->set(60000));
});

it('can set 3600000 to 01:00:00.000 time', function () {
    $cast = new StopwatchCast;
    $this->assertEquals('01:00:00.000', $cast->set(3600000));
});

it('can set 3660000 to 01:01:00.000 time', function () {
    $cast = new StopwatchCast;
    $this->assertEquals('01:01:00.000', $cast->set(3660000));
});

it('can set 3666000 to 01:01:06.000 time', function () {
    $cast = new StopwatchCast;
    $this->assertEquals('01:01:06.000', $cast->set(3666000));
});

it('can set 3666600 to 01:01:06.600 time', function () {
    $cast = new StopwatchCast;
    $this->assertEquals('01:01:06.600', $cast->set(3666600));
});

it('can set NULL to 00:00:00.000 time', function () {
    $cast = new StopwatchCast;
    $this->assertEquals('00:00:00.000', $cast->set(null));
});

it('cant set negative number to get time', function () {
    $cast = new StopwatchCast;
    $this->expectException(LogicException::class);
    $cast->set(-1);
});

it('cant set string to get time', function () {
    $cast = new StopwatchCast;
    $this->expectException(LogicException::class);
    $cast->set('asd');
});

it('cant set float to get time', function () {
    $cast = new StopwatchCast;
    $this->expectException(LogicException::class);
    $cast->set(5.4);
});
