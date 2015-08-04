<?php

namespace Socieboy\Forms;

use Collective\Html\FormBuilder as Form;
use Illuminate\Support\Facades\File;
use Illuminate\View\Factory as View;
use Illuminate\Session\Store as Session;

class FieldBuilder {

    /**
     * @var Form
     */
    protected $form;
    /**
     * @var View
     */
    protected $view;
    /**
     * @var Session
     */
    protected $session;


    /**
     * Set default or custom classes for the type of control.
     *
     * @var array
     */
    protected $defaultClass;

    /**
     * Initialize construct.
     *
     * @param Form    $form
     * @param View    $view
     * @param Session $session
     */
    public function __construct(Form $form, View $view, Session $session)
    {
        $this->defaultClass = config('field-builder.css');
        $this->form = $form;
        $this->view = $view;
        $this->session = $session;
    }

    /**
     * Return the css class for the control,
     * If does not exist a class for the type of control
     * We return the default class.
     *
     * @param $type
     * @return mixed
     */
    public function getDefaultClass($type)
    {
        if (isset ($this->defaultClass[$type]))
        {
            return $this->defaultClass[$type];
        }

        return $this->defaultClass['default'];
    }


    /**
     * We  build the css passed of the user with the
     * Custom bootstrap template.
     *
     * @param $type
     * @param $attributes
     */
    public function buildCssClasses($type, &$attributes)
    {
        $defaultClasses = $this->getDefaultClass($type);

        if (isset ($attributes['class']))
        {
            $attributes['class'] .= ' ' . $defaultClasses;
        }
        else
        {
            $attributes['class'] = $defaultClasses;
        }
    }

    /**
     * We create the label for the control.
     *
     * @param $name
     * @return string
     */
    public function buildLabel($name)
    {
        if (\Lang::has('validation.attributes.' . $name))
        {
            $label = \Lang::get('validation.attributes.' . $name);
        }
        else
        {
            $label = str_replace('_', ' ', $name);
        }

        return ucfirst($label);
    }

    /**
     * Build all control with the css class, label, and input.
     *
     * @param       $type
     * @param       $name
     * @param null  $value
     * @param array $attributes
     * @param array $options
     * @return string
     */
    public function buildControl($type, $name, $value = null, $attributes = [], $options = [])
    {

        switch ($type)
        {
            case 'select':
                $options = ['' => config('field-builder.select')] + $options;
                return $this->form->select($name, $options, $value, $attributes);
            case 'password':
                return $this->form->password($name, $attributes);
            case 'checkbox':
                return $this->form->checkbox($name, $value, isset($attributes['checked']), $attributes);
            case 'textarea':
                return $this->form->textarea($name, $value, $attributes);
            case 'number':
                return $this->form->number($name, $value, $attributes);
            case 'radio':
                return $this->form->radio($name, $value, $attributes);
            case 'email':
                return $this->form->email($name, $value, $attributes);
            default:
                return $this->form->input($type, $name, $value, $attributes);
        }
    }

    /**
     * We had the label to display errors right in the bottom
     * Of the control.
     *
     * @param $name
     * @return null
     */
    public function buildError($name)
    {
        $error = null;
        if ($this->session->has('errors'))
        {
            $errors = $this->session->get('errors');

            if ($errors->has($name))
            {
                $error = $errors->first($name);
            }
        }
        return $error;
    }

    /**
     * Build the template of the control.
     * We check if the assets of the package where published in the views/vendor directory
     * Of the project, if they don not have published in their project's, we check if exists a custom
     * View for the type of control on the package views.
     * If does not exist the view for the control we return the default.
     *
     * @param $type
     * @param $attributes
     * @return string
     */
    public function buildTemplate($type, $attributes)
    {
        // Path to vendor form builder views.
        $publishedPath = base_path().'/resources/views/vendor/socieboy/forms/';

        // If the view was published on the project.
        if (File::exists($publishedPath . $type . '.blade.php'))
        {
            /**
             * If the attributes has a icon we are going to display the
             * view for group controls, other way we just return the custom view.
             */
            if(isset($attributes['icon']))
            {
                return $publishedPath . 'group.blade.php';
            }

            return $publishedPath . $type . '.blade.php';
        }

        /**
         * If the user has not published the views we check if the type of view exits.
         * If the view does not exits we continue.
         */
        else if($this->view->exists('FieldBuilder::' . $type))
        {
            return 'FieldBuilder::' . $type;
        }

        /**
         * If the attributes has an icon we return the view of the package for group controls.
         */
        if(isset($attributes['icon']))
        {
            return 'FieldBuilder::group';
        }

        /**
         * If the view is in the package and does not have icon we just return the custom view.
         */

        return 'FieldBuilder::default';
    }

    /**
     * We create the control input.
     *
     * @param       $type
     * @param       $name
     * @param null  $value
     * @param array $attributes
     * @param array $options
     * @return \Illuminate\Contracts\View\View
     */
    public function input($type, $name, $value = null, $attributes = [], $options = [])
    {
        $this->buildCssClasses($type, $attributes);

        $icon = $this->buildIcon($attributes);

        $label = $this->buildLabel($name);

        $control = $this->buildControl($type, $name, $value, $attributes, $options);

        $error = $this->buildError($name);

        $template = $this->buildTemplate($type, $attributes);

        return $this->view->make($template, compact ('name', 'label', 'control', 'error', 'icon'));
    }

    public function buildIcon(&$attributes)
    {
        if(isset($attributes['icon']))
        {
            return $attributes['icon'];
        }
        return '';
    }

    /**
     * Create a password field.
     *
     * @param       $name
     * @param array $attributes
     * @return \Illuminate\Contracts\View\View
     */
    public function password($name, $attributes = [])
    {
        return $this->input('password', $name, null, $attributes);
    }


    /**
     * Create a control hidden.
     *
     * @param      $name
     * @param null $value
     * @param      $attributes
     * @return \Illuminate\Contracts\View\View
     */
    public function hidden($name, $value = null, $attributes)
    {
        return $this->input('hidden', $name, $value, $attributes);
    }

    /**
     * Create a email field.
     *
     * @param       $name
     * @param array $attributes
     * @return \Illuminate\Contracts\View\View
     */
    public function email($name, $attributes = [])
    {
        return $this->input('email', $name, null, $attributes);
    }

    /**
     * Create a select list.
     *
     * @param       $name
     * @param       $options
     * @param null  $value
     * @param array $attributes
     * @return \Illuminate\Contracts\View\View
     */
    public function select($name, $options, $value = null, $attributes = [])
    {
        return $this->input('select', $name, $value, $attributes, $options);
    }

    /**
     * @param $method
     * @param $params
     *
     * @return mixed
     */
    public function __call($method, $params)
    {
        array_unshift($params, $method);
        return call_user_func_array([$this, 'input'], $params);
    }
} 