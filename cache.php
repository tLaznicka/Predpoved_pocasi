<?php
    function checkCache($cacheFile, $cacheDuration) {
        clearstatcache();

        if (file_exists($cacheFile) && filemtime($cacheFile) > time() - $cacheDuration) {
            include($cacheFile);
            exit;
        }

        ob_start();
    }

    function saveCache($cacheFile, $contents) {
        $handle = fopen($cacheFile, "w");
        fwrite($handle, $contents);
        fclose($handle);

        include($cacheFile);
    }

    $cacheDuration = 600; 
    $cacheFile = basename($_SERVER['PHP_SELF'], '.php') . '.cache';

    checkCache($cacheFile, $cacheDuration);

    print "Toto je předpověď počasí.<br />";
    print "Poslední aktualizace: " . date("H:i:s");

    $contents = ob_get_contents();
    ob_end_clean();

    saveCache($cacheFile, $contents);
?>
