<?php
/**
 * Created by PhpStorm.
 * Author: mickael-dev
 * File: index.php
 * Created: 21/04/2020 03:22
 */

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Tabulate\Table;

$table = new Table();
$table->addRow(['S/N', 'Movie Name', 'Director', 'Estimated Budget', 'Release Date']);
$table->addRow(['tt1979376', 'Toy Story 4', 'Josh Cooley', '$200,000,000', '21 June 2019']);
$table->addRow(['tt1979376', 'La menace Fantome', 'Star Wars', '$100,000,000', '01 April 2004']);

$table->view();
