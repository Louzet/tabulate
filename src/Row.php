<?php
/**
 * Created by PhpStorm.
 * Author: mickael-dev
 * File: Row.php
 * Created: 21/04/2020 01:05
 */

declare(strict_types=1);

namespace Tabulate;

class Row implements \Countable
{
    /**
     * @var Cell[]
     */
    private $cells = [];

    /**
     * @param Cell $cell
     */
    public function addCell(Cell $cell): void
    {
        $this->cells[] = $cell;
    }

    /**
     * @param int $index
     * @return Cell
     */
    public function cell(int $index): Cell
    {
        return $this->cells[$index];
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return \count($this->cells);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->cells);
    }
}
