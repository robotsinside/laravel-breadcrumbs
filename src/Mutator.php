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
			$this->segments->forget($this->segments->search(function ($segment) use ($remove) {
				return $segment->segment() == $remove;
			}));
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
	 * Set a path on the specified model segment.
	 *
	 * @param Model $model
	 * @return void
	 */
	protected function setPath($model)
	{
		$segment = $this->segments->filter(function ($segment) use ($model) {
			if($segment->segment() == $segment->request()->route($model)->getRouteKey()) {
				return $segment;
			}
		})->first();

		// When excluding models (using the exclude settings key) the segment is null.
		!$segment ?: $segment->setPath($segment->request()->route($model)->breadcrumbPath());
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
