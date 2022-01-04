<?php

declare(strict_types=1);

namespace MarsRover;

use MarsRover\Exception\UnreachablePositionException;
use MarsRover\ValueObject\Direction;
use MarsRover\ValueObject\PlanetMap;
use MarsRover\ValueObject\Position;

final class MarsRover
{
    public function __construct(private PlanetMap $map, private Position $currentPosition, private Direction $direction)
    {
    }

    public function move(string $commandSet): string|null
    {
        for ($i = 0; $i < strlen($commandSet); $i++) {
            $command = $commandSet[$i];
            try {
                if ($command === 'F') {
                    $this->currentPosition = $this->map->nextPositionFor($this->currentPosition, $this->direction());
                }
                if ($command === 'R') {
                    $this->direction = $this->direction->right();
                }
                if($command === 'L') {
                    $this->direction = $this->direction->left();
                }
            } catch (UnreachablePositionException $positionException) {
                return $positionException->getMessage();
            }
        }
        return null;
    }

    public function latitude(): int
    {
        return $this->currentPosition->latitude();
    }

    public function longitude(): int
    {
        return $this->currentPosition->longitude();
    }

    public function direction(): string
    {
        return $this->direction->value();
    }
}