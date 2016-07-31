<?php namespace Sanatorium\Help\Repositories\Help;

use Cartalyst\Support\Traits;
use Illuminate\Container\Container;
use Symfony\Component\Finder\Finder;

class HelpRepository implements HelpRepositoryInterface {

	use Traits\ContainerTrait, Traits\EventTrait, Traits\RepositoryTrait, Traits\ValidatorTrait;

	/**
	 * The Data handler.
	 *
	 * @var \Sanatorium\Help\Handlers\Help\HelpDataHandlerInterface
	 */
	protected $data;

	/**
	 * The Eloquent help model.
	 *
	 * @var string
	 */
	protected $model;

	/**
	 * Constructor.
	 *
	 * @param  \Illuminate\Container\Container  $app
	 * @return void
	 */
	public function __construct(Container $app)
	{
		$this->setContainer($app);

		$this->setDispatcher($app['events']);

		$this->data = $app['sanatorium.help.help.handler.data'];

		$this->setValidator($app['sanatorium.help.help.validator']);

		$this->setModel(get_class($app['Sanatorium\Help\Models\Help']));
	}

	/**
	 * {@inheritDoc}
	 */
	public function grid()
	{
		return $this
			->createModel();
	}

	/**
	 * {@inheritDoc}
	 */
	public function findAll()
	{
		return $this->container['cache']->rememberForever('sanatorium.help.help.all', function()
		{
			return $this->createModel()->get();
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function find($id)
	{
		return $this->container['cache']->rememberForever('sanatorium.help.help.'.$id, function() use ($id)
		{
			return $this->createModel()->find($id);
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForCreation(array $input)
	{
		return $this->validator->on('create')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForUpdate($id, array $input)
	{
		return $this->validator->on('update')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function store($id, array $input)
	{
		return ! $id ? $this->create($input) : $this->update($id, $input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function create(array $input)
	{
		// Create a new help
		$help = $this->createModel();

		// Fire the 'sanatorium.help.help.creating' event
		if ($this->fireEvent('sanatorium.help.help.creating', [ $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForCreation($data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Save the help
			$help->fill($data)->save();

			// Fire the 'sanatorium.help.help.created' event
			$this->fireEvent('sanatorium.help.help.created', [ $help ]);
		}

		return [ $messages, $help ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update($id, array $input)
	{
		// Get the help object
		$help = $this->find($id);

		// Fire the 'sanatorium.help.help.updating' event
		if ($this->fireEvent('sanatorium.help.help.updating', [ $help, $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForUpdate($help, $data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Update the help
			$help->fill($data)->save();

			// Fire the 'sanatorium.help.help.updated' event
			$this->fireEvent('sanatorium.help.help.updated', [ $help ]);
		}

		return [ $messages, $help ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function delete($id)
	{
		// Check if the help exists
		if ($help = $this->find($id))
		{
			// Fire the 'sanatorium.help.help.deleted' event
			$this->fireEvent('sanatorium.help.help.deleted', [ $help ]);

			// Delete the help entry
			$help->delete();

			return true;
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function enable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => true ]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function disable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => false ]);
	}

}
