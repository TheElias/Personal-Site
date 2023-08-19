<?php

function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}

function parse_env_file_contents_to_array($env_file_contents) {
    $env_array = array();
    $lines = explode("\n", $env_file_contents);
    foreach ($lines as $line) {
        //Check for empty strings or "commented" out lines
        if ($line === '' || substr($line, 0, 1) === '#') {
            continue;
        }
        $equals_pos = strpos($line, '=');
        if ($equals_pos !== false) {
            $key = substr($line, 0, $equals_pos);
            $value = substr($line, $equals_pos + 1);
            if (substr($value, 0, 1) === '"' && substr($value, -1) === '"') {
                $value = substr($value, 1, -1);
            }
            elseif (substr($value, 0, 1) === "'" && substr($value, -1) === "'") {
                $value = substr($value, 1, -1);
            }
            $env_array[$key] = $value;
        }
    }
    return $env_array;
}
?>