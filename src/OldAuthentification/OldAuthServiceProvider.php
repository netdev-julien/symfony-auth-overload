<?php namespace OldAuthentification;

use OldAuthentification\Hasher\SymfonyHasher;
use Illuminate\Support\ServiceProvider;

class OldAuthServiceProvider implements ServiceProvider {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('alexkevler/symfony-auth-overload', 'alexkevler/symfony-auth-overload');

		$this->observeEvents();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerHasher();
	}

	/**
	 * Register the hasher used by Sentry.
	 *
	 * @return void
	 */
	protected function registerHasher()
	{
		$this->app['oldauth.hasher'] = $this->app->share(function($app)
		{
			$hasher = $app['config']['alexkevler/symfony-auth-overload::hasher'];

			switch ($hasher)
			{
				case 'symfony':
					return new SymfonyHasher;
					break;
			}

			throw new \InvalidArgumentException("Invalid hasher [$hasher] chosen.");
		});
	}

}