<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Pagination class adapted to use with Kostache
 *
 * @package    Kostache
 * @category   Pagination
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
class Kohana_Kostache_Pagination extends Pagination
{
	/**
	 * Creates a new Pagination object.
	 *
	 * @param   array  configuration
	 * @return  Kostache_Pagination
	 */
	public static function factory(array $config = array())
	{
		return new Kostache_Pagination($config);
	}

	/**
	 * Creates a new Pagination object.
	 *
	 * @param   array  configuration
	 * @return  void
	 */
	public function __construct(array $config = array())
	{
		$this->config += array(
			'kostache' => NULL,
			'partial' => NULL,
		);
		parent::__construct($config);
		// If view, partial name and Kostache instance are set, add pagination partial
		if ($this->config['kostache'] instanceof Kostache AND $this->config['partial'] AND $this->config['view'])
		{
			$this->partial($this->config['kostache'], $this->config['partial'], $this->config['view']);
		}
	}

	/**
	 * Returns Pagination object as array
	 *
	 * @return array
	 */
	public function as_array()
	{
		$array = get_object_vars($this);
		unset($array['config']);
		return $array;
	}

	/**
	 * Sets Kostache partial
	 * 
	 * @param  Kostache $instance
	 * @param  string $partial_name
	 * @param  string $view
	 */
	public function partial(Kostache $instance, $partial_name, $view = NULL)
	{
		$instance->partial($partial_name, $this->_view_path($view));
		return $this;
	}

	/**
	 * Render pagination links.
	 * 
	 * @param   string $view
	 * @return  Kostache_Pagination_Base
	 */
	public function render($view = NULL)
	{
		// Automatically hide pagination whenever it is superfluous
		if ($this->config['auto_hide'] === TRUE AND $this->total_pages <= 1)
		{
			return NULL;
		}

		// Convert view path to class name (e.g. 'pagination/basic' to 'pagination_basic')
		$view = str_replace('/', '_', $this->_view_path($view));

		// Create view instance
		$instance = new $view($this);
		if ( ! $instance instanceof Kostache_Pagination_Base)
		{
			throw new Kohana_Exception('Pagination view class :class must extend Kostache_Pagination_Base', array(':class' => $view));
		}

		// Render view
		return $instance->render();
	}

	/**
	 * Returns view path
	 * 
	 * @param   string $path
	 * @return  string
	 */
	protected function _view_path($path = NULL)
	{
		if ($path === NULL)
		{
			// Use the view from config
			$path = $this->config['view'];
		}
		return $path;
	}
}
