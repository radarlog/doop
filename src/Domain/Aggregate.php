<?php
declare(strict_types=1);

namespace Radarlog\Doop\Domain;

interface Aggregate
{
    public function id(): Identity;

    public function getState(): State;

    public static function fromState(State $state): Aggregate;
}
