<?php namespace Boyhagemann\Navigation;

use Illuminate\Support\ServiceProvider;

use URL, Route, Menu;

class NavigationServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('boyhagemann/navigation');
        
        
        Route::get('cms/navigation/import', array(
            'as'    => 'navigation.import',
            'uses'  => 'Boyhagemann\Navigation\Controller\ImportController@index'
        ));
        Route::post('cms/navigation/import/route', array(
            'as'    => 'navigation.import.route',
            'uses'  => 'Boyhagemann\Navigation\Controller\ImportController@route'
        ));
        Route::get('cms/import/all', array(
            'as'    => 'navigation.import.all',
            'uses'  => 'Boyhagemann\Navigation\Controller\ImportController@all'
        ));              
        
                
        Route::resource('cms/navigation', 'Boyhagemann\Navigation\Controller\NavigationController');
        
        
        Menu::handler('main')->add(URL::route('cms.navigation.index'), '<i class="icon-sitemap"></i> Navigation');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}