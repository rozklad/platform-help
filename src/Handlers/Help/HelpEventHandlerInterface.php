<?php namespace Sanatorium\Help\Handlers\Help;

use Sanatorium\Help\Models\Help;
use Cartalyst\Support\Handlers\EventHandlerInterface as BaseEventHandlerInterface;

interface HelpEventHandlerInterface extends BaseEventHandlerInterface {

	/**
	 * When a help is being created.
	 *
	 * @param  array  $data
	 * @return mixed
	 */
	public function creating(array $data);

	/**
	 * When a help is created.
	 *
	 * @param  \Sanatorium\Help\Models\Help  $help
	 * @return mixed
	 */
	public function created(Help $help);

	/**
	 * When a help is being updated.
	 *
	 * @param  \Sanatorium\Help\Models\Help  $help
	 * @param  array  $data
	 * @return mixed
	 */
	public function updating(Help $help, array $data);

	/**
	 * When a help is updated.
	 *
	 * @param  \Sanatorium\Help\Models\Help  $help
	 * @return mixed
	 */
	public function updated(Help $help);

	/**
	 * When a help is deleted.
	 *
	 * @param  \Sanatorium\Help\Models\Help  $help
	 * @return mixed
	 */
	public function deleted(Help $help);

}
