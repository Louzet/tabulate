<?php
/**
 * Created by PhpStorm.
 * Author: mickael-dev
 * File: FontColor.php
 * Created: 21/04/2020 11:49
 */

declare(strict_types=1);

namespace Tabulate\style;

class FontColor
{
    public const DARK       = 'dark';
    public const RED        = 'red';
    public const GREEN      = 'green';
    public const BROWN      = 'brown';
    public const BLUE       = 'blue';
    public const MAGENTA    = 'magenta';
    public const CYAN       = 'cyan';
    public const LIGHTGREY  = 'lightgrey';
    public const DARKGREY   = 'darkgrey';
    public const LIGHTRED   = 'lightred';
    public const LIGHTGREEN = 'lightgreen';
    public const YELLOW     = 'yellow';
    public const LIGHTBLUE  = 'lightblue';
    public const PURPLE     = 'purple';
    public const LIGHTCYAN  = 'lightcyan';
    public const WHITE      = 'white';

    private $textColor;

    public function color(string $color): FontColor
    {
        $this->textColor = $color;

        return $this;
    }
}
