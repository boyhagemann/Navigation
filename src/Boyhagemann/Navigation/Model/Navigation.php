<?php

namespace Boyhagemann\Navigation\Model;

use Boyhagemann\Pages\Model\Page;

class Navigation extends \Baum\Node 
{
    protected $guarded = array();

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'navigation';
    
    public static $rules = array(
        'title' => 'required'
    );
    
    /**
     * 
     * @param \Boyhagemann\Pages\Model\Page $page
     */
    static public function createFromPage(Page $page)
    {
        $navigation = new self();
        $navigation->page_id = $page->id;
        $navigation->save();

        $parentPath = substr($page->path, 0, strrpos($page->path, '/'));
        $parent = Page::where('path', '=', $parentPath)->get()->first();
        if($parent) {
            $navigation->makeChildOf($parent->navigation()->first());
        }
    }
    
    public function page()
    {
        return $this->belongsTo('Boyhagemann\Pages\Model\Page');
    }
}