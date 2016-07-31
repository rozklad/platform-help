<?php namespace Sanatorium\Help\Widgets;

use Cartalyst\Interpret\Interpreter;
use Illuminate\Filesystem\Filesystem;
use Sanatorium\Help\Controllers\Admin\HelpsController;
use Route;

class Help {

	public function __construct(Interpreter $interpreter, Filesystem $filesystem)
	{
		$this->interpreter = $interpreter;
		$this->filesystem = $filesystem;
	}

	public function route($route, $view = true)
	{
		$helps = app('Sanatorium\Help\Repositories\Help\HelpRepositoryInterface');

		if ( $help = $helps->where('route', $route->getName())->first() ) {

		    $content = $this->getContent(HelpsController::getAbsoluteDirectory() . $help->file);

		    if ( $view )
                return view('sanatorium/help::widgets/help', compact('content'));

			return $content;

		}

        return null;
	}

	public function getContent($file)
	{

        $filesystem = $this->filesystem;

        $contents  = $filesystem->get($file);
        $extension = $filesystem->extension($file);

        return $this->interpreter->make($contents, $extension)->toHtml() ?: $file;
	}

	public function hookMenu()
    {
        $route = \Route::getCurrentRoute();

        $helps = app('Sanatorium\Help\Repositories\Help\HelpRepositoryInterface');

        if ( $help = $helps->where('route', $route->getName())->first() ) {

            return '<li>
            <a href="#" data-toggle="quickview" data-toggle-element="#quickview">
                <i class="fa fa-life-ring"></i>
            </a>
        </li>';

        }

        return null;
    }

    public function hookFooter()
    {
        return $this->route(\Route::getCurrentRoute());
    }

}
