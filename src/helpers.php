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

function select($name, $options = array(), $value = null, $attributes = array())
{
    $field = app('Socieboy\Forms\FieldBuilder');

    return $field->input('select', $name, $value, $attributes, $options);
}

function email($name, $value = null, $attributes = array(), $options = array())
{
    $field = app('Socieboy\Forms\FieldBuilder');

    return $field->input('email', $name, $value, $attributes, $options);
}