<?php

$runner->addTestsFromDirectory(__DIR__.'/tests/Units');

$script->noCodeCoverageForNamespaces('mageekguy', 'Symfony');
$script->bootstrapFile(__DIR__.DIRECTORY_SEPARATOR.'.atoum.bootstrap.php');
