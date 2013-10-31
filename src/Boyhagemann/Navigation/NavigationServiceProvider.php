<?php namespace Boyhagemann\Navigation;

use Illuminate\Support\ServiceProvider;
use Boyhagemann\Pages\Model\Page;
use Boyhagemann\Navigation\Model\Node;
use Event;

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
		$this->package('navigation', 'navigation');

		$this->app->register('Menu\MenuServiceProvider');
                
                
		/**
		 * Each time a resource page is created, we add the appropriate navigation on that page.
		 */
		Event::listen('page.createResourcePages', function(Array $pages) {
                    
                    foreach($pages as $action => $page) {

                        // Left menu root node
                        $left = Node::create(array(
                            'title' => $page->title,
                            'page_id' => $page->id,
                            'container_id' => \NavigationContainersTableSeeder::LEFT,
                        ));

                        // Right menu root node
                        $right = Node::create(array(
                            'title' => $page->title,
                            'page_id' => $page->id,
                            'container_id' => \NavigationContainersTableSeeder::RIGHT,
                        ));

                        $base = substr($page->alias, 0, strrpos($page->alias, '.'));

                        switch($action) {

                            case 'index':

                                // Admin dashboard
                                $left->children()->create(array(
                                    'title' => 'Dashboard',
                                    'page_id' => Page::whereAlias('admin.index')->first()->id,
                                ));

                                break;

                            case 'create':

                                // Overview
                                $overview = Page::whereAlias($base . '.index')->first();
                                $left->children()->create(array(
                                    'title' => $overview->title,
                                    'page_id' => $overview->id,
                                ));

                                break;

                            case 'edit':


                                // Overview
                                $overview = Page::whereAlias($base . '.index')->first();
                                $left->children()->create(array(
                                    'title' => $overview->title,
                                    'page_id' => $overview->id,
                                ));

                                // Delete
                                $destroy = Page::whereAlias($base . '.destroy')->first();
                                $right->children()->create(array(
                                    'title' => $destroy->title,
                                    'page_id' => $destroy->id,
                                ));

                                break;
                        }
                        
                    }
                    

		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->package('navigation', 'navigation');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('navigation');
	}

}