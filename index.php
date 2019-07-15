<?php

require_once('importDB.php');
require_once('exportDB.php');

if ($_SERVER['argc'] >= 1) {
    switch( $_SERVER['argv'][1] ) {
        case 'import':
            import();
            break;
        case 'export':
            export();
            break;
    }
} else {
    echo 'Write "import" or "export" keywords to make application work.';
}
