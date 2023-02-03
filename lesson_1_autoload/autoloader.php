<?php
function classLoader($classname) {
    $fileName = $classname . '.php';
    $fileName = str_replace("GeekBrains\\LevelTwo", "src", $fileName);
    $fileName = str_replace("\\", DIRECTORY_SEPARATOR, $fileName);
    $fileName = str_replace("_", DIRECTORY_SEPARATOR, $fileName);
    if(file_exists($fileName)){
        include $fileName;
    }
}
spl_autoload_register('classLoader');