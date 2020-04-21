<?php
/**
 * Created by PhpStorm.
 * Author: mickael-dev
 * File: Format.php
 * Created: 21/04/2020 02:08
 */

declare(strict_types=1);

namespace Tabulate;

class Format
{
    public $marginLeft = 1;
    public $marginRight = 1;
    public $marginTop = 1;
    public $marginBottom = 1;

    public $paddingLeft = 1;
    public $paddingRight = 1;
    public $paddingTop = 1;
    public $paddingBottom = 1;

    public $borderLeft = '|';
    public $borderRight = '|';
    public $borderTop = '_';
    public $borderBottom = '_';

    public $cornerLeft = '+';
    public $cornerRight = '+';
    public $cornerTop = '+';
    public $cornerBottom = '+';

    public $columnSeparator = '|';
}