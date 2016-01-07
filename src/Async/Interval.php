<?php 
namespace CapMousse\ReactRestify\Async;

class Interval 
{
	private static $intervalCollection;

	private $time;
	private $callback;

	public function __construct(callable $callback, $time)
	{
		$this->callback = $callback;
		$this->time = $time;
	}

	public static function run(callable $callback, $time = 1)
	{	
		if (! self::$intervalCollection)
			self::$intervalCollection = new \ArrayIterator();

		self::$intervalCollection->append(new static($callback, $time));
	}

	public static function getIntervals()
	{
		return self::$intervalCollection;
	}

	public function getTime()
	{
		return $this->time;
	}

	public function getCallback()
	{
		return $this->callback;
	}
}
