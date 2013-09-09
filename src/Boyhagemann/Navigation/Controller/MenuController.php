<?php

namespace Boyhagemann\Navigation\Controller;

use Boyhagemann\Navigation\Model\Node;
use Config, App;

class MenuController extends \BaseController
{
    protected $menu;
    
    public function admin()
    {
        $menu = App::make('Menu\Menu');
        $this->menu = $menu->handler('admin', array('class' => 'nav navbar-nav'));
        
        $nodes = Node::whereDepth(0)->whereContainerId(1)->with('page')->get();

        foreach($nodes as $node) {
            $this->buildMenu($node);
        }
        
        return $this->menu->render();
    }
    
    public function buildMenu($node)
    {
		if($node->page) {
        	$this->menu->add(url($node->page->route), $node->title);
		}
		else {
			$this->menu->add('', $node->title);
		}
    }

}