<?php namespace Sanatorium\Help\Providers;

use Cartalyst\Support\ServiceProvider;

class HelpServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		// Register the attributes namespace
		$this->app['platform.attributes.manager']->registerNamespace(
			$this->app['Sanatorium\Help\Models\Help']
		);

		// Subscribe the registered event handler
		$this->app['events']->subscribe('sanatorium.help.help.handler.event');

		// Register the Blade @help widget
		$this->registerBladeHelpWidget();

        // Register hook
        $this->registerHooks();
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		// Register the repository
		$this->bindIf('sanatorium.help.help', 'Sanatorium\Help\Repositories\Help\HelpRepository');

		// Register the data handler
		$this->bindIf('sanatorium.help.help.handler.data', 'Sanatorium\Help\Handlers\Help\HelpDataHandler');

		// Register the event handler
		$this->bindIf('sanatorium.help.help.handler.event', 'Sanatorium\Help\Handlers\Help\HelpEventHandler');

		// Register the validator
		$this->bindIf('sanatorium.help.help.validator', 'Sanatorium\Help\Validator\Help\HelpValidator');
	}

	/**
     * Register the Blade @help widget.
     *
     * @return void
     */
	public function registerBladeHelpWidget()
	{
        $this->app['blade.compiler']->directive('help', function ($value) {
            return "<?php echo Widget::make('sanatorium/help::help.route', array$value); ?>";
        });
	}

    /**
     * Register all hooks.
     *
     * @return void
     */
    protected function registerHooks()
    {
        $hooks = [
            'menu.system' => 'sanatorium/help::help.hookMenu',
            'admin.scripts.footer' => 'sanatorium/help::help.hookFooter',
        ];

        $manager = $this->app['sanatorium.hooks.manager'];

        foreach ($hooks as $position => $hook) {
            $manager->registerHook($position, $hook);
        }
    }

}
