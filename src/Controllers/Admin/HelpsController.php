<?php namespace Sanatorium\Help\Controllers\Admin;

use Platform\Access\Controllers\AdminController;
use Sanatorium\Help\Repositories\Help\HelpRepositoryInterface;
use Route;
use File;

class HelpsController extends AdminController {

	/**
	 * {@inheritDoc}
	 */
	protected $csrfWhitelist = [
		'executeAction',
	];

	/**
	 * The Help repository.
	 *
	 * @var \Sanatorium\Help\Repositories\Help\HelpRepositoryInterface
	 */
	protected $helps;

	/**
	 * Holds all the mass actions we can execute.
	 *
	 * @var array
	 */
	protected $actions = [
		'delete',
		'enable',
		'disable',
	];

	/**
	 * Constructor.
	 *
	 * @param  \Sanatorium\Help\Repositories\Help\HelpRepositoryInterface  $helps
	 * @return void
	 */
	public function __construct(HelpRepositoryInterface $helps)
	{
		parent::__construct();

		$this->helps = $helps;
	}

	/**
	 * Display a listing of help.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('sanatorium/help::helps.index');
	}

	/**
	 * Datasource for the help Data Grid.
	 *
	 * @return \Cartalyst\DataGrid\DataGrid
	 */
	public function grid()
	{
		$data = $this->helps->grid();

		$columns = [
			'id',
			'route',
			'file',
			'created_at',
		];

		$settings = [
			'sort'      => 'created_at',
			'direction' => 'desc',
		];

		$transformer = function($element)
		{
			$element->edit_uri = route('admin.sanatorium.help.helps.edit', $element->id);

			return $element;
		};

		return datagrid($data, $columns, $settings, $transformer);
	}

	/**
	 * Show the form for creating new help.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new help.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating help.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating help.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified help.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		$type = $this->helps->delete($id) ? 'success' : 'error';

		$this->alerts->{$type}(
			trans("sanatorium/help::helps/message.{$type}.delete")
		);

		return redirect()->route('admin.sanatorium.help.helps.all');
	}

	/**
	 * Executes the mass action.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function executeAction()
	{
		$action = request()->input('action');

		if (in_array($action, $this->actions))
		{
			foreach (request()->input('rows', []) as $row)
			{
				$this->helps->{$action}($row);
			}

			return response('Success');
		}

		return response('Failed', 500);
	}

	/**
	 * Shows the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return mixed
	 */
	protected function showForm($mode, $id = null)
	{
		// Do we have a help identifier?
		if (isset($id))
		{
			if ( ! $help = $this->helps->find($id))
			{
				$this->alerts->error(trans('sanatorium/help::helps/message.not_found', compact('id')));

				return redirect()->route('admin.sanatorium.help.helps.all');
			}
		}
		else
		{
			$help = $this->helps->createModel();
		}

		$directory = $this->getRelativeDirectory();

		$routes = Route::getRoutes();

		$files = File::allFiles(base_path($directory));

		// Show the page
		return view('sanatorium/help::helps.form', compact('mode', 'help', 'routes', 'files', 'directory'));
	}

	/**
	 * Processes the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function processForm($mode, $id = null)
	{
		// Store the help
		list($messages) = $this->helps->store($id, request()->all());

		// Do we have any errors?
		if ($messages->isEmpty())
		{
			$this->alerts->success(trans("sanatorium/help::helps/message.success.{$mode}"));

			return redirect()->route('admin.sanatorium.help.helps.all');
		}

		$this->alerts->error($messages, 'form');

		return redirect()->back()->withInput();
	}

	public static function getRelativeDirectory()
    {
        return str_replace( base_path(), '', self::getAbsoluteDirectory());
    }

    public static function getAbsoluteDirectory()
    {
        return __DIR__ . '/../../../storage/';
    }

	public function refresh()
    {
        $directory = $this->getRelativeDirectory();

        foreach ( $this->helps->all() as $help )
        {

            $help->file = str_replace($directory, '', $help->file);
            $help->save();
        }

        $this->alerts->success(trans("sanatorium/help::helps/message.refresh.success"));

        return redirect()->route('admin.sanatorium.help.helps.all');
    }

}
