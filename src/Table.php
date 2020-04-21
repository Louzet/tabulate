<?php
/**
 * Created by PhpStorm.
 * Author: mickael-dev
 * File: Cell.php
 * Created: 21/04/2020 00:52
 */

declare(strict_types=1);

namespace Tabulate;

class Table
{
    /**
     * @var Row[]
     */
    private $rows;

    /**
     * @param array $cells
     */
    public function addRow(array $cells): void
    {
        $row = new Row();
        foreach ($cells as $cell) {
            $row->addCell(new Cell($cell));
        }

        $this->rows[] = $row;
    }

    /**
     * @param int $index
     * @return int
     */
    private function columnWidth(int $index): int
    {
        $result = 0;
        foreach ($this->rows as $row) {
            if ($index < \count($row)) {
                $cell = $row->cell($index);
                $cellWidth = null !== $cell ? $cell->size() : 0;
                $result = max($result, $cellWidth);
                /*if ($result < $cellWidth) {
                    $result = $cellWidth;
                }*/
            }
        }

        return $result;
    }

    /*private function rowHeight(int $index)
    {
        $result = 0;
        if ($index < \count($this->rows)) {

        }
        return result;
    }*/

}
