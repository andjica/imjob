<?php

if (!function_exists('camelToSnakeCase')) {
    function camelToSnakeCase(array $data): array
    {
        $convertedData = [];

        foreach ($data as $key => $value) {
            $snakeKey = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $key));

            if (is_array($value)) {
                $convertedData[$snakeKey] = camelToSnakeCase($value);
                continue;
            }

            $convertedData[$snakeKey] = $value;
        }

        return $convertedData;
    }
}
