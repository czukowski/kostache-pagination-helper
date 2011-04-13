<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Base pagination view class
 *
 * @package    Kostache
 * @category   Pagination
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
abstract class Kohana_Kostache_Pagination_Base
{
	/**
	 * @var Kostache_Pagination
	 */
	protected $pagination;

	/**
	 * Returns pagination object as array
	 * @return array
	 */
	public function pagination()
	{
		return $this->pagination->as_array();
	}

	/**
	 * Pagination views must implement this method
	 * @return Kohana_Pagination_Basic
	 */
	abstract public function render();

	/**
	 * Class constructor
	 * @param Pagination $pagination
	 */
	public function __construct(Pagination $pagination)
	{
		$this->pagination = $pagination;
	}
}
