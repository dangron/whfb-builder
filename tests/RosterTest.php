<?php

use App\Profile;
use App\Roster;
use App\Type;
use App\Unit;

$lordsProfile = Profile::lord('Chaos Lord', 210);
$warhoundsProfile = Profile::of('Warhounds', 6, Type::Core);
$roster = Roster::of(
    Unit::of($lordsProfile, 1),
    Unit::of($warhoundsProfile, 5),
    Unit::of($warhoundsProfile, 10)
);

test('rosters count points', function () use ($roster){
    expect($roster->cost())->toBe(300);
    expect($roster->cost(Type::Lords))->toBe(210);
    expect($roster->cost(Type::Core))->toBe(90);
    expect($roster->cost(Type::Special))->toBe(0);
});

test('rosters count models', function () use ($roster) {
    expect($roster->modelCount())->toBe(16);
    expect($roster->modelCount(Type::Lords))->toBe(1);
    expect($roster->modelCount(Type::Core))->toBe(15);
    expect($roster->modelCount(Type::Special))->toBe(0);
});

test('rosters count units', function () use ($roster) {
    expect($roster->unitCount())->toBe(3);
    expect($roster->unitCount(Type::Lords))->toBe(1);
    expect($roster->unitCount(Type::Core))->toBe(2);
    expect($roster->unitCount(Type::Special))->toBe(0);
});

test('rosters can have a points limit', function () {
    $roster = Roster::empty()->setPointsLimit(2000);
    expect($roster->pointsLeft())->toBe(2000);
    $roster->addUnit(Unit::of(Profile::lord('Chaos Lord', 210)));
    expect($roster->pointsLeft())->toBe(2000 - 210);
});