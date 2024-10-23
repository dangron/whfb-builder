<?php

use App\Exception\InvalidSelectionException;
use App\Profile;
use App\Type;
use App\Unit;

$chosenProfile = Profile::of('Chosen', 18, Type::Special)
    ->withUpgrade('Champion', 20)
    ->withMagicItemAllowance(25, ['require-upgrade' => 'Champion', 'limit' => 1]);

test('profiles can have a magic items allowance', function () use ($chosenProfile) {
    expect($chosenProfile->magicItemAllowance)->toBe(25);
});

test('units can have a magic items according to profile allowance', function () use ($chosenProfile) {
    $chosen = Unit::of($chosenProfile, 10)->withUpgrades('Champion')->withMagicItem('Sword of Battle', 25);
    expect($chosen->selectedMagicItems)->toBe(['Sword of Battle' => 25]);
});

test('magic items are unique', function () use ($chosenProfile) {
    $chosen = Unit::of($chosenProfile, 10)
        ->withUpgrades('Champion')
        ->withMagicItem('Sword of Battle', 25)
        ->withMagicItem('Sword of Battle', 25);
})->throws(InvalidSelectionException::class);

test('units cannot have a more magic items than they are allowed', function () use ($chosenProfile) {
    Unit::of($chosenProfile, 10)->withUpgrades('Champion')
        ->withMagicItem('Biting Blade', 5)
        ->withMagicItem('Enchanted Shield', 15);
})->throws(InvalidSelectionException::class);

test('magic items are added to a unit cost', function () use ($chosenProfile) {
    $chosen = Unit::of($chosenProfile, 10)
        ->withUpgrades('Champion')
        ->withMagicItem('Sword of Battle', 25);
    expect($chosen->cost())->toBe(225);
});

test('a units magic items cannot exceed its allowance', function () use ($chosenProfile) {
    Unit::of($chosenProfile, 10)->withMagicItem('Filth Mace', 35);
})->throws(InvalidSelectionException::class);

test('disallows adding magic items to units without an allowance', function () {
    $warhoundsProfile = Profile::of('Warhouds', 6, Type::Core);
    Unit::of($warhoundsProfile, 5)->withMagicItem("Sword of Battle", 25);
})->throws(InvalidSelectionException::class);