<?php

namespace Boyhagemann\Navigation\Model;

class Node extends \Baum\Node
{

    protected $table = 'navigation_node';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'title',
        'route',
        'container_id'
        );

    /**
     * @return Container
     */
    public function container()
    {
        return $this->belongsTo('Boyhagemann\Navigation\Model\Container');
    }


}

