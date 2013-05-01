<?php

namespace Boyhagemann\Navigation\Controller;

use URL, Menu, View;

class MenuController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function main()
    {
        $menu = Menu::handler('main', array('class' => 'nav'))
                     ->add('/', '<i class="icon-home"></i> Home')
                     ->add(URL::route('cms.pages.index'), '<i class="icon-file"></i> Pages');        
        
        return View::make('navigation::menu.main', compact('menu'));
    }
    
}