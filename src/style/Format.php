<?php
/**
 * Created by PhpStorm.
 * Author: mickael-dev
 * File: Format.php
 * Created: 21/04/2020 02:08
 */

declare(strict_types=1);

namespace Tabulate\style;

class Format
{
    public $width;
    public $height;

    public $fontStyle = [];
    public $fontAlign = FontAlign::LEFT;

    public $marginLeft = 2;
    public $marginRight = 2;
    public $marginTop = 2;
    public $marginBottom = 2;

    public $paddingLeft = 1;
    public $paddingRight = 1;
    public $paddingTop = 1;
    public $paddingBottom = 1;

    public $borderLeft = '|';
    public $borderRight = '|';
    public $borderTop = '-';
    public $borderBottom = '-';

    public $corner = '+';

    public $columnSeparator = '|';

    /**
     * @param int $width
     * @return self
     */
    public function setWidth(int $width): self
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @param mixed $height
     * @return self
     */
    public function setHeight($height): self
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @param FontStyle[] $fontStyle
     * @return Format
     */
    public function setFontStyle(array $fontStyle): self
    {
        $this->fontStyle = $fontStyle;
        return $this;
    }

    /**
     * @param string $fontAlign
     * @return $this
     */
    public function setFontAlign(string $fontAlign): self
    {
        $this->fontAlign = $fontAlign;
        return $this;
    }

    /**
     * @param int $marginLeft
     * @return self
     */
    public function setMarginLeft(int $marginLeft): self
    {
        $this->marginLeft = $marginLeft;
        return $this;
    }

    /**
     * @param int $marginRight
     * @return self
     */
    public function setMarginRight(int $marginRight): self
    {
        $this->marginRight = $marginRight;
        return $this;
    }

    /**
     * @param int $marginTop
     * @return self
     */
    public function setMarginTop(int $marginTop): self
    {
        $this->marginTop = $marginTop;
        return $this;
    }

    /**
     * @param int $marginBottom
     * @return self
     */
    public function setMarginBottom(int $marginBottom): self
    {
        $this->marginBottom = $marginBottom;
        return $this;
    }

    /**
     * @param int $paddingLeft
     * @return self
     */
    public function setPaddingLeft(int $paddingLeft): self
    {
        $this->paddingLeft = $paddingLeft;
        return $this;
    }

    /**
     * @param int $paddingRight
     * @return self
     */
    public function setPaddingRight(int $paddingRight): self
    {
        $this->paddingRight = $paddingRight;
        return $this;
    }

    /**
     * @param int $paddingTop
     * @return self
     */
    public function setPaddingTop(int $paddingTop): self
    {
        $this->paddingTop = $paddingTop;
        return $this;
    }

    /**
     * @param int $paddingBottom
     * @return self
     */
    public function setPaddingBottom(int $paddingBottom): self
    {
        $this->paddingBottom = $paddingBottom;
        return $this;
    }

    /**
     * @param string $borderLeft
     * @return self
     */
    public function setBorderLeft(string $borderLeft): self
    {
        $this->borderLeft = $borderLeft;
        return $this;
    }

    /**
     * @param string $borderRight
     * @return self
     */
    public function setBorderRight(string $borderRight): self
    {
        $this->borderRight = $borderRight;
        return $this;
    }

    /**
     * @param string $borderTop
     * @return self
     */
    public function setBorderTop(string $borderTop): self
    {
        $this->borderTop = $borderTop;
        return $this;
    }

    /**
     * @param string $borderBottom
     * @return self
     */
    public function setBorderBottom(string $borderBottom): self
    {
        $this->borderBottom = $borderBottom;
        return $this;
    }

    /**
     * @param string $corner
     * @return Format
     */
    public function setCorner(string $corner): Format
    {
        $this->corner = $corner;
        return $this;
    }

    /**
     * @param string $columnSeparator
     * @return self
     */
    public function setColumnSeparator(string $columnSeparator): self
    {
        $this->columnSeparator = $columnSeparator;
        return $this;
    }
}
