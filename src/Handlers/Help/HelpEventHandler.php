<?php namespace Sanatorium\Help\Handlers\Help;

use Illuminate\Events\Dispatcher;
use Sanatorium\Help\Models\Help;
use Cartalyst\Support\Handlers\EventHandler as BaseEventHandler;

class HelpEventHandler extends BaseEventHandler implements HelpEventHandlerInterface {

	/**
	 * {@inheritDoc}
	 */
	public function subscribe(Dispatcher $dispatcher)
	{
		$dispatcher->listen('sanatorium.help.help.creating', __CLASS__.'@creating');
		$dispatcher->listen('sanatorium.help.help.created', __CLASS__.'@created');

		$dispatcher->listen('sanatorium.help.help.updating', __CLASS__.'@updating');
		$dispatcher->listen('sanatorium.help.help.updated', __CLASS__.'@updated');

		$dispatcher->listen('sanatorium.help.help.deleted', __CLASS__.'@deleted');
	}

	/**
	 * {@inheritDoc}
	 */
	public function creating(array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function created(Help $help)
	{
		$this->flushCache($help);
	}

	/**
	 * {@inheritDoc}
	 */
	public function updating(Help $help, array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function updated(Help $help)
	{
		$this->flushCache($help);
	}

	/**
	 * {@inheritDoc}
	 */
	public function deleted(Help $help)
	{
		$this->flushCache($help);
	}

	/**
	 * Flush the cache.
	 *
	 * @param  \Sanatorium\Help\Models\Help  $help
	 * @return void
	 */
	protected function flushCache(Help $help)
	{
		$this->app['cache']->forget('sanatorium.help.help.all');

		$this->app['cache']->forget('sanatorium.help.help.'.$help->id);
	}

}
