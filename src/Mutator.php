<?php

namespace RobotsInside\Breadcrumbs;

abstract class Mutator
{
	/**
	 * The URL segments.
	 *
	 * @var \Illuminate\Support\Collection
	 */
	private $segments;

	public function construct()
	{
		$this->request = request();
	}

	/**
	 * Delegates to the users' mutator.
	 *
	 * @return void
	 */
	abstract public function mutate();

	/**
	 * Remove segments.
	 *
	 * @param array $removals
	 * @return void
	 */
	protected function remove(array $removals)
	{
		// dd($this->segments);
		foreach($removals as $remove) {
			$this->segments->each(function ($segment, $key) use ($remove) {
				if($segment->segment() === $remove) {
					$this->segments->forget($key);
				}
			});
		}
	}

	/**
	 * Add a segment
	 * 
	 * @param Segment $segment
	 * @param string $after
	 * @param string $url
	 * @return void
	 */
	protected function add($segment, $after, $url)
	{
		$result = $this->segments->search(function ($s) use ($after) {
			return $s->segment() == $after;
		});

		$this->segments->splice($result, 0, [new Segment($segment, $url)]);
	}

	/**
	 * Get the customized segments.
	 *
	 * @return Collection
	 */
	public function getSegments()
	{
		return $this->segments;
	}

	/**
	 * Set the segments.
	 *
	 * @param Collection $segments
	 * @return void
	 */
	public function setSegments($segments)
	{
		$this->segments = $segments;
	}
}
