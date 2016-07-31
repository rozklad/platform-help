<?php namespace Sanatorium\Help\Widgets;

use Cartalyst\Interpret\Interpreter;
use Illuminate\Filesystem\Filesystem;
use Sanatorium\Help\Controllers\Admin\HelpsController;

class Help {

	public function __construct(Interpreter $interpreter, Filesystem $filesystem)
	{
		$this->interpreter = $interpreter;
		$this->filesystem = $filesystem;
	}

	public function route($route)
	{
		$helps = app('Sanatorium\Help\Repositories\Help\HelpRepositoryInterface');

		if ( $help = $helps->where('route', $route->getName())->first() ) {

			return $this->getContent(HelpsController::getAbsoluteDirectory() . $help->file);

		}

		return $route->getName();
	}

	public function getContent($file)
	{

        $filesystem = $this->filesystem;

        $contents  = $filesystem->get($file);
        $extension = $filesystem->extension($file);

        return $this->interpreter->make($contents, $extension)->toHtml() ?: $file;
	}

}
