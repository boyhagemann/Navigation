<?php

namespace Boyhagemann\Navigation\Model;

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

}

