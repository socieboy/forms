## Laravel 5.1 Bootstrap Form Builder

### Installation

Add to your composer.json file the package.

```
"socieboy/forms" : "dev-master"
```

Update your dependencies

```
composer update
```

After install this package you have to set the service provider on your config/app.php file

```
Socieboy\Forms\FormsServiceProvider::class
```

Copy the config file to your config directory.

```
php artisan vendor:publish
```

### Usage

```
{!! checkbox('checkbox') !!}

<div class="form-group">
	<div class="checkbox">
		<label>
			<input class="" name="checkbox" type="checkbox"> Checkbox
		</label>
	</div>
</div>

-----------------

{!! text('text', 'hello') !!}

<div class="form-group">
    <label for="Text">Text</label>
    <input class="form-control" name="text" type="text" value="hello">
</div>

-----------------

{!! radio('radio') !!}

<div class="form-group">
    <label for="Radio">Radio</label>
    <input checked="checked" name="radio" type="radio" value="radio">
</div>

-----------------

{!! select('select', [
    'USA' => 'United States of America',
    'MXN' => 'Mexico',
    'Other' => 'Other'], 'MXN')
!!}

<div class="form-group">
    <label for="Select">Select</label>
    <select class="form-control" name="select">
        <option value="">Select</option>
        <option value="USA">United States of America</option>
        <option value="MXN" selected="selected">Mexico</option>
        <option value="Other">Other</option>
    </select>
</div>

-----------------

{!! email('email', null, ['placeholder' => 'email@example.com']) !!}

<div class="form-group">
    <label for="Email">Email</label>
    <input placeholder="email@example.com" class="form-control" name="email" type="email">
</div>

-----------------

{!! email('email', null, ['placeholder' => 'email@example.com', 'icon' => 'glyphicon glyphicon-envelope']) !!}

<div class="input-group">
  	<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
  	<input placeholder="email@example.com" class="form-control" name="email" type="email">
</div>
```

If you want to edit some of the templates for each control, just publish the assets.

```
php artisan vendor:publish --tag=form-builder-views
```

On your views directory you will find this path.
```
views/vendor/socieboy/forms 
```

So for example, if you want to create a view for file control, just create another view with the name of the control.
```
file.blade.php
```
Then just set your css template, and you can use the variables
```
$control
$label
$icon
$error
```

By the way the package has support to display the erros if the field has validation.