<?php

function text($name, $value = null, $attributes = array(), $options = array())
{
    $field = app('Socieboy\Forms\FieldBuilder');

    return $field->input('text', $name, $value, $attributes, $options);
}

function checkbox($name, $value = null, $attributes = array(), $options = array())
{
    $field = app('Socieboy\Forms\FieldBuilder');

    return $field->input('checkbox', $name, $value, $attributes, $options);
}

function radio($name, $value = null, $attributes = array(), $options = array())
{
    $field = app('Socieboy\Forms\FieldBuilder');

    return $field->input('radio', $name, $value, $attributes, $options);
}

function select($name, $value = null, $attributes = array(), $options = array())
{
    $field = app('Socieboy\Forms\FieldBuilder');

    return $field->input('select', $name, $attributes, $value, $options);
}

function email($name, $value = null, $attributes = array(), $options = array())
{
    $field = app('Socieboy\Forms\FieldBuilder');

    return $field->input('email', $name, $value, $attributes, $options);
}