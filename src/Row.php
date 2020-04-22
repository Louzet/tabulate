<?php
/**
 * Created by PhpStorm.
 * Author: mickael-dev
 * File: Row.php
 * Created: 21/04/2020 01:05
 */

declare(strict_types=1);

namespace Tabulate;

use Tabulate\style\Format;

class Row implements \Countable
{
    /**
     * @var Cell[]
     */
    private $cells = [];

    /** @var Format */
    private $format;

    public function __construct()
    {
        $this->format = new Format();
    }

    /**
     * @param Cell $cell
     */
    public function addCell(Cell $cell): void
    {
        $this->cells[] = $cell;
    }

    /**
     * @return Cell[]
     */
    public function getCells(): array
    {
        return $this->cells;
    }

    /**
     * @param int $index
     * @return Cell|null
     */
    public function cell(int $index): ?Cell
    {
        if ($index < \count($this->cells)) {
            return $this->cells[$index];
        }
        return null;
    }

    /**
     * @return int
     */
    public function height(): int
    {
        $result = 1;
        foreach ($this->cells as $cell) {
            $cellData = $cell->data();
            $formatWidth = $cell->format()->width;

            if (null !== $formatWidth && \strlen($cellData) > $formatWidth) {
                $dataWidth = (int) ceil(\strlen($cellData) / $formatWidth);
                /** @var int $result */
                $result = max($result, $dataWidth);
            } else {
                $result = max($result, 1);
            }
        }

        return (int) $result;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->cells);
    }
}
