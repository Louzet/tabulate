<?php
/**
 * Created by PhpStorm.
 * Author: mickael-dev
 * File: Cell.php
 * Created: 21/04/2020 00:52
 */

declare(strict_types=1);

namespace Tabulate;

use Tabulate\style\FontAlign;
use Tabulate\style\Format;

class Table implements TableInterface
{
    /**
     * @var Row[]
     */
    private $rows;

    /** @var Format */
    private $format;

    public function __construct()
    {
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
                $this->printCellHeader($i, $j);
            }
            echo PHP_EOL;

            // paddint top
            for ($k = 0; $k < $this->format->paddingTop; $k++) {
                $this->printPaddingRow($k);
                echo PHP_EOL;
            }

            // row content
            for ($m = 0; $m < $rowHeight; $m++) {
                foreach ($cells as $n => $nValue) {
                    $columnWidth = $this->columnWidth($n);
                    $cellContent = $nValue->data();
                    $pos = $m * $columnWidth;
                    $size = \mb_strlen($cellContent);

                    if ($pos < $size) {
                        $remaining = $size - $pos;
                        $subRowContent[] = substr($cellContent, $pos, min($remaining, $columnWidth));
                    } else {
                        $subRowContent[] = '';
                    }

                    $columnWidths[] = $columnWidth;
                }

                $this->printRowContent($subRowContent, $columnWidths, $i);
            }

            // padding bottom
            for ($p = 0; $p < $this->format->paddingBottom; $p++) {
                $this->printPaddingRow($p);
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
                    $result = max($result, $cellWidth) + 2;
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
     * @param int $rowIndex
     */
    private function printPaddingRow(int $rowIndex): void
    {
        for ($colIndex = 0, $colIndexMax = \count( $this->rows[$rowIndex] ); $colIndex < $colIndexMax; $colIndex++) {
            $width = $this->columnWidth($colIndex);

            // add padding to width
            $width += $this->format->paddingLeft;
            $width += $this->format->paddingRight;

            if ($colIndex === 0) {
                echo $this->format->borderLeft;
            } else {
                echo $this->format->columnSeparator;
            }

            $i = 0;

            while ($i < $width) {
                echo ' ';
                $i++;
            }
        }
        echo $this->format->borderRight;
    }

    /**
     * @param int $rowIndex
     * @param int $colIndex
     */
    private function printCellHeader(int $rowIndex, int $colIndex): void
    {
        $row = $this->rows[$rowIndex];
        $rowFormat = $row->getFormat();
        $cellFormat = $row->cell($colIndex)->getFormat();
        $width = $this->columnWidth($colIndex);

        $format = $this->getFormat($rowFormat, $cellFormat);

        $width += $format->paddingLeft;
        $width += $format->paddingRight;

        if ($colIndex === 0) {
            echo $format->corner;
        }

        $i = 0;
        while ($i < $width) {
            echo $format->borderTop;
            $i++;
        }
        echo $format->corner;
    }

    /**
     * @param string[] $rowContent
     * @param array $columnWidths
     * @param int $rowIndex
     */
    private function printRowContent(array $rowContent, array $columnWidths, int $rowIndex): void
    {
        $row = $this->rows[$rowIndex];
        $rowFormat = $row->getFormat();

        $rowContentSize = \count($rowContent);
        $format = null;

        for ($i = 0; $i < $rowContentSize; $i++) {
            $cell = $row->cell($i);
            $cellFormat = $cell->getFormat();

            $format = $this->getFormat($rowFormat, $cellFormat);

            $cellContent = $rowContent[$i];

            if ($i === 0) {
                echo $format->borderLeft;
            } else {
                echo $format->columnSeparator;
            }

            for ($j = 0; $j < $format->paddingLeft; $j++) {
                echo ' ';
            }

            switch ($format->fontAlign) {
                case FontAlign::LEFT:
                    $this->printContentLeftAlignement($cellContent, $columnWidths[$i]);
                    break;
                case FontAlign::CENTER:
                    $this->printContentCenterAlignement($cellContent, $columnWidths[$i]);
                    break;
                case FontAlign::RIGHT:
                    $this->printContentRightAlignement($cellContent, $columnWidths[$i]);
                    break;
            }

            for ($m = 0; $m < $format->paddingRight; $m++) {
                echo ' ';
            }
        }
        echo $format->borderRight;
        echo PHP_EOL;
    }

    private function printCellFooter(&$stream, int $rowIndex, int $colIndex): void
    {
        $row = $this->rows[$rowIndex];
        $rowFormat = $row->getFormat();
        $cellFormat = $row->cell($colIndex)->getFormat();
        $width = $this->columnWidth($colIndex);

        $format = $this->getFormat($rowFormat, $cellFormat);

        $width += $format->paddingLeft;
        $width += $format->paddingRight;

        if ($colIndex === 0) {
            echo $format->corner;
        }

        $i = 0;
        while ($i < $width) {
            echo $format->borderTop;
            $i++;
        }
        echo $format->corner;
    }

    private function printContentLeftAlignement(string $cellContent, int $columnWidth): void
    {
        echo $cellContent;
        $contentWidth = \mb_strlen($cellContent);
        if ($contentWidth < $columnWidth) {
            for ($i = 0; $i < $columnWidth - $contentWidth; $i++) {
                echo ' ';
            }
        }
    }

    private function printContentCenterAlignement(string $cellContent, int $columnWidth): void
    {
        $contentWidth = \mb_strlen($cellContent);
        $numSpaces = $columnWidth - $contentWidth;
        if ($numSpaces % 2 === 0) {
            for ($i = 0; $i < $numSpaces / 2; $i++) {
                echo ' ';
            }
            echo $cellContent;
            for ($j = 0; $j < $numSpaces / 2; $j++) {
                echo ' ';
            }
        } else {
            $numSpacesBefore = ($numSpaces / 2) + 1;
            for ($k = 0; $k < $numSpacesBefore; $k++) {
                echo ' ';
            }
            echo $cellContent;
            for ($l = 0; $l < $numSpacesBefore; $l++) {
                echo ' ';
            }
        }
    }

    private function printContentRightAlignement(string $cellContent, int $columnWidth): void
    {
        $contentWidth = \mb_strlen($cellContent);
        if ($contentWidth < $columnWidth) {
            for ($i = 0; $i < $columnWidth - $contentWidth; $i++) {
                echo ' ';
            }
        }
        echo $cellContent;
    }

    /**
     * @param Format|null $rowFormat
     * @param Format|null $cellFormat
     * @return Format
     */
    private function getFormat(Format $rowFormat = null, Format $cellFormat = null): Format
    {

        if (null !== $rowFormat) {
            $result = $rowFormat;
        } elseif (null !== $cellFormat) {
            $result = $cellFormat;
        } else {
            $result = $this->format;
        }

        return $result;
    }
}
