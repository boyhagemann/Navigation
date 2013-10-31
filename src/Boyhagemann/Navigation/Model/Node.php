<?php

namespace Boyhagemann\Navigation\Model;

use Illuminate\Database\Eloquent\Collection;

class Node extends \Baum\Node
{

    protected $table = 'navigation_nodes';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'title',
        'container_id',
        'page_id',
		'icon_class',
        'params',
        );

    /**
     * @return Container
     */
    public function container()
    {
        return $this->belongsTo('Boyhagemann\Navigation\Model\Container');
    }

    /**
     * @return \Boyhagemann\Pages\Model\Page
     */
    public function page()
    {
            return $this->belongsTo('Boyhagemann\Pages\Model\Page');
    }


	public function getParamsAttribute($value)
	{
		if(!$value) {
			return array();
		}

		return unserialize($value);
	}

	public function setParamsAttribute(Array $value = array())
	{
		$this->attributes['params'] = serialize($value);
	}


	/**
	 *
	 * @param type $containerName
	 * @return Node
	 */
	static public function getChildrenByContainer($containerName)
	{
		$qb = self::query();
		$qb->join('navigation_containers', 'navigation_nodes.container_id', '=', 'navigation_containers.id')
			->where('navigation_containers.name', '=', $containerName)
			->select('navigation_nodes.*');

		return $qb->with('page')->get();
	}

    /**
     * 
     * @param type $routeName
     * @param type $containerName
     * @return Node
     */
    static public function findRootByRouteAndContainer($routeName, $containerName)
    {        
        $qb = self::query();
        $qb->join('pages', 'navigation_nodes.page_id', '=', 'pages.id')
           ->join('navigation_containers', 'navigation_nodes.container_id', '=', 'navigation_containers.id')
           ->where('navigation_containers.name', '=', $containerName)
           ->where('pages.alias', '=', $routeName)
           ->select('navigation_nodes.*');
        
        return $qb->first();
    }
    
    /**
     * 
     * @param type $routeName
     * @param type $containerName
     * @return Collection
     */
    static public function getChildrenByRouteAndContainer($routeName, $containerName)
    {
        $node = self::findRootByRouteAndContainer($routeName, $containerName);
        
        if(!$node) {
            return new Collection;
        }
        
        return $node->children()->get();
    }
}

