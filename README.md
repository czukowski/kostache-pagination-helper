Pagination Helper for KOstache
==============================

This module might save you some time adding pagination to your application, that use KOstache.

You'll be able to easily add pagination to your views (including multiple independent paginations) and change pagination styles across
your application as simple as changing a config parameter.

Basic usage
-----------

In your template:

    ...
    {{#pagination}}{{>pagination}}{{/pagination}}
    ...

In your view file:

	public function __construct($template = NULL, array $partials = NULL)
	{
		parent::__construct($template, $partials);
		// Create pagination instance
		$this->pagination = Kostache_Pagination::factory(array(
			'kostache' => $this,
			'items_per_page' => 50,
			'partial' => 'pagination',
			'view' => 'pagination/basic',
		));
	}

Notes:

* The `config` parameter `kostache` is an instance of `Kostache` class, i.e. your view model.
* The `config` parameter `partial` is the name of partial you use in your template file, e.g. you can pass `'pagination'`, if you have
  `{{>pagination}}` in your template. That will also be the name of your view method (see below).
* If you pass both of the above parameters to pagination constructor, the partial will be automatically added to your view model.
* You don't have to specify `view` parameter as `'pagination/basic'`, since it is Pagination default value.

View file continued:

		public function pagination()
		{
			$this->pagination->total_items = $this->_get_data_count();
			return $this->pagination->render();
		}

Notes:

* The method name is the same as a section name you use in your template, for instance if you have `pagination()` method, you need the
  following section in the template: `{{#pagination}}{{> ... }}{{/pagination}}`. The partial name doesn't have to match the section name.
* Here you just set `total_items` property of pagination and call `render()` method. It doesn't actually render view to a string,
  but rather returns an array to your view, for use in the appropriate template partial.
* You'd replace `$this->_get_data_count()` with your own method call, that returns items count.
* If items count is known during class construction (i.e. it doesn't depend on any values set by a controller), you, of course, may
  set it in constructor right away and not do that in `pagination` method.

Alternative usage
-----------------

If you don't like setting `total_items` after creating pagination instance, since it, well, may not be "correct" way to do so, you can
also create and return its instance in `pagination()` method:

	public function pagination()
	{
		return Kostache_Pagination::factory(array(
			'items_per_page' => 50,
			'total_items' => $this->_get_data_count(),
			'view' => 'pagination/punbb',
		))->render();
	}

But in this case, you'd need to manually add partial, because it's too late to do so at this point. For example:

	public function __construct($template = NULL, array $partials = NULL)
	{
		$this->_partials['pagination'] = 'pagination/punbb';
		parent::__construct($template, $partials);
	}

Note, that in this example pagination uses another pagination style (punbb), that I've ported from Kohana 2.

Requirements
------------

 * [KOstache 2](https://github.com/zombor/KOstache)
 * Made for [Kohana 3.1](http://kohanaframework.org), but may work with 3.0
