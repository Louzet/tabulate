<?php
/**
 * Created by PhpStorm.
 * Author: mickael-dev
 * File: Cell.php
 * Created: 21/04/2020 00:52
 */

declare(strict_types=1);

namespace Tabulate;

class Cell
{
    /**
     * @var string
     */
    private $data;

    /**
     * Cell constructor.
     * @param string $data
     */
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function data(): string
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return \strlen($this->data);
    }
}
