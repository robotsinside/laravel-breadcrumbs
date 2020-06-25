<?php

namespace RobotsInside\Breadcrumbs;

abstract class Mutator
{
	/**
	 * The mutation hook.
	 *
	 * @return void
	 */
	abstract public function mutate();

	/**
	 * Remove segments.
	 *
	 * @param array $segments
	 * @return void
	 */
	protected function remove(array $segments)
	{
		foreach($segments as $remove) {
			$this->segments->each(function ($segment) use ($remove) {
				if($segment->segment() === $remove) {
					$this->segments->forget($this->segments->search($remove));
				}
			});
		}
	}

	/**
	 * Add a segment
	 * 
	 * @TODO
	 *
	 * @param Segment $segment
	 * @param string|null $after
	 * @return void
	 */
	protected function add($segment, $after = null)
	{

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
