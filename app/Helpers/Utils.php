<?php

if (!function_exists('treeselect_options')) {
    function treeselect_options($model, $id = 'id', $label = 'name')
    {
        $options = [];
        foreach ($model as $m) {
            $options[] = ['id' => $m->{$id}, 'label' => $m->{$label}];
        }

        return $options;
    }
}
