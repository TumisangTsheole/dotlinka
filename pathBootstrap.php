<?php
/**
    This file is to be used by every .php file that is part of program execution
    It sets a 'PROJECT_ROOT' constant which is to be used to get the 
    absolute root project path for every executed .php file.

    Exclusion of this constant/file will break all the files that depend on it 
    by preventing "include/require" statements from resolving to the correct paths
    leading to "No such file or directory" errors
*/

define('PROJECT_ROOT', __DIR__);