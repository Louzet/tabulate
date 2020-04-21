<?php
/**
 * Created by PhpStorm.
 * Author: mickael-dev
 * File: Cell.php
 * Created: 21/04/2020 00:52
 */

declare(strict_types=1);

namespace Tabulate;

class Table implements TableInterface
{
    /**
     * @var Row[]
     */
    private $rows;

    /** @var Format */
    private $format;

    private $in;

    private $out;

    public function __construct()
    {
        $this->in = STDIN;
        $this->out = STDOUT;
        $this->format = new Format();
    }

    public function view(): void
    {
        $stream = STDOUT;

        foreach ($this->rows as $i => $row) {
            $rowHeight = $this->rowHeight($i);
            $cells = $row->getCells();
            $countCells = \count($cells);
            /** @var int[] $columnWidths */
            $columnWidths = [];
            /** @var string[] $subRowContent */
            $subRowContent = [];

            // Header
            for ($j = 0, $jMax = \count( $cells ); $j < $jMax; $j++) {
                $this->printCellHeader($stream, $i, $j);
            }
            echo PHP_EOL;

            // paddint top
            for ($k = 0; $k < $this->format->paddingTop; $k++) {
                $this->printPaddingRow($stream, $k);
                echo PHP_EOL;
            }

            // row content
            for ($m = 0; $m < $rowHeight; $m++) {
                for ($n = 0; $n < $countCells; $n++) {
                    $columnWidth = $this->columnWidth($n);
                    $cellContent = $cells[1]->data();
                    $pos = $m * $columnWidth;
                    $size = \strlen($cellContent);

                    if ($pos < $size) {
                        $remaining = $size - $pos;
                        $subRowContent[] = substr($cellContent, $pos, min($remaining, $columnWidth));
                    } else {
                        $subRowContent[] = '';
                    }

                    $columnWidths[] = $columnWidth;
                }

                $this->printRowContent($stream, $subRowContent, $columnWidths);
            }

            // padding bottom
            for ($p = 0; $p < $this->format->paddingBottom; $p++) {
                $this->printPaddingRow($stream, $p);
                echo PHP_EOL;
            }

            // footer
            if ($i + 1 === \count($this->rows)) {
                for ($q = 0; $q < $countCells; $q++) {
                    $this->printCellFooter($stream, $i, $q);
                }
            }
        }
        echo PHP_EOL;
    }

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

    public function column(int $index)
    {
        $column = null;
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
                if (null !== $this->format->width) {
                    $result = $this->format->width;
                } else {
                    $result = max($result, $cellWidth);
                }
            }
        }

        return $result;
    }

    /**
     * @param int $index
     * @return int
     */
    private function rowHeight(int $index): int
    {
        $result = 1;
        if ($index < \count($this->rows)) {
            $result = max($result, $this->rows[$index]->height());
        }
        return $result;
    }

    /**
     * @param resource|false $stream
     * @param int $rowIndex
     */
    private function printPaddingRow(&$stream, int $rowIndex): void
    {
        for ($colIndex = 0, $colIndexMax = \count( $this->rows[$rowIndex] ); $colIndex < $colIndexMax; $colIndex++) {
            $width = $this->columnWidth($colIndex);
            $height = $this->rowHeight($rowIndex);
            $cell = $this->rows[$rowIndex]->cell($colIndex);

            // add padding to width
            $width += $this->format->paddingLeft;
            $width += $this->format->paddingRight;

            echo $this->format->borderLeft;

            $i = 0;

            while ($i < $width) {
                echo ' ';
                $i++;
            }
        }
        echo $this->format->borderRight;
    }

    /**
     * @param $stream
     * @param int $rowIndex
     * @param int $colIndex
     */
    private function printCellHeader(&$stream, int $rowIndex, int $colIndex): void
    {
        $width = $this->columnWidth($colIndex);
        $height = $this->rowHeight($rowIndex);
        $cell = $this->rows[$rowIndex]->cell($colIndex);

        $cellContent = '';

        if (null !== $cell && $cell->hasValue()) {
            $cellContent = $cell->data();
        }

        $width += $this->format->paddingLeft;
        $width += $this->format->paddingRight;

        if ($colIndex === 0) {
            echo $this->format->corner;
        }

        $i = 0;
        while ($i < $width) {
            echo $this->format->borderTop;
            $i++;
        }
        echo $this->format->corner;
    }

    /**
     * @param $stream
     * @param string[] $rowContent
     * @param array $columnWidths
     */
    private function printRowContent(&$stream, array $rowContent, array $columnWidths): void
    {
        $rowContentSize = \count($rowContent);
        for ($i = 0; $i < $rowContentSize; $i++) {
            $cellContent = $rowContent[$i];
            echo $this->format->borderLeft;
            for ($j = 0; $j < $this->format->paddingLeft; $j++) {
                echo ' ';
            }

            echo $cellContent;

            $contentWidth = \strlen($cellContent);
            $columnWidth = $columnWidths[$i];

            if ($contentWidth < $columnWidth) {
                for ($k = 0; $k < $columnWidth - $contentWidth; $k++) {
                    echo ' ';
                }
            }

            for ($m = 0; $m < $this->format->paddingRight; $m++) {
                echo ' ';
            }
        }
        echo $this->format->borderRight;
        echo PHP_EOL;
    }

    private function printCellFooter(&$stream, int $rowIndex, int $colIndex): void
    {
        $width = $this->columnWidth($colIndex);
        $height = $this->rowHeight($rowIndex);
        $cell = $this->rows[$rowIndex]->cell($colIndex);

        $cellContent = '';

        if (null !== $cell && $cell->hasValue()) {
            $cellContent = $cell->data();
        }

        $width += $this->format->paddingLeft;
        $width += $this->format->paddingRight;

        if ($colIndex === 0) {
            echo $this->format->corner;
        }

        $i = 0;
        while ($i < $width) {
            echo $this->format->borderTop;
            $i++;
        }
        echo $this->format->corner;
    }
}
