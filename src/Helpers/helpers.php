<?php

if (!function_exists('convert_canvas_limits_to_array')) {
    function convert_canvas_limits_to_array(string $str)
    {
        $types = explode(';', $str);

        $result = [];
        foreach ($types as $typeStr) {
            [$type, $limits] = explode(':', $typeStr);
            [$max, $min] = explode(',', $limits);
            [$maxWidth, $maxHeight] = explode('*', $max);
            [$minWidth, $minHeight] = explode('*', $min);
            $result[$type] = [
                'max' => [
                    'width' => intval($maxWidth),
                    'height' => intval($maxHeight)
                ],
                'min' => [
                    'width' => intval($minWidth),
                    'height' => intval($minHeight)
                ],
            ];
        }
        return $result;
    }
}

if (!function_exists('convert_preview_canvas_limits_to_array')) {
    function convert_preview_canvas_limits_to_array(string $str)
    {
        $types = explode(';', $str);

        $result = [];
        foreach ($types as $typeStr) {
            [$type, $limits] = explode(':', $typeStr);
            $previewSizes = explode(',', $limits);
            $sizes = [];
            foreach ($previewSizes as $previewSize) {
                $explodedPreviewSize = explode('|', $previewSize);
                $previewName = 'default';
                $size = [];
                if (count($explodedPreviewSize) < 2) {
                    $explodedSize = explode('*', $explodedPreviewSize[0]);
                    $size = [
                        'width' => intval($explodedSize[0]),
                        'height' => intval($explodedSize[1]),
                    ];
                } else {
                    $previewName = $explodedPreviewSize[0];
                    $explodedSize = explode('*', $explodedPreviewSize[1]);
                    $size = [
                        'width' => intval($explodedSize[0]),
                        'height' => intval($explodedSize[1]),
                    ];
                }
                $sizes[$previewName] = $size;
            }

            $result[$type] = $sizes;
        }
        return $result;
    }
}

if (!function_exists('get_request_rules_for')) {
    function get_request_rules_for(string $type = 'default'): array
    {
        $rules = [
            'max:'.config('onzame_images.limits.file_size'),
            'mimes:'.config('onzame_images.limits.mimes'),
        ];
        $configLimits = config('onzame_images.limits.canvas_sizes.'.$type);
        if (empty($configLimits)) {
            return $rules;
        }
        $rules[] = 'dimensions:min_width='.$configLimits['min']['width'].',min_height='.$configLimits['min']['height'].',max_width='.$configLimits['max']['width'].',max_height='.$configLimits['max']['height'];
        return $rules;
    }
}

if (!function_exists('get_request_rules_for_as_string')) {
    function get_request_rules_for_as_string(string $type = 'default'): string
    {
        return implode('|', get_request_rules_for($type));
    }
}
