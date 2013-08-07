<?php

namespace Boyhagemann\Navigation\Controller;

use Boyhagemann\Crud\CrudController;
use Boyhagemann\Form\FormBuilder;
use Boyhagemann\Model\ModelBuilder;
use Boyhagemann\Overview\OverviewBuilder;
use DB;

class NodeController extends CrudController
{
    /**
     * @param FormBuilder $fb
     */
    public function buildForm(FormBuilder $fb)
    {
        $fb->text('title')->label('Title');
        $fb->text('route')->label('Route');
        $fb->modelSelect('container_id')->alias('container')->label('Container')->model('Boyhagemann\Navigation\Model\Container');
    }

    /**
     * @param ModelBuilder $mb
     */
    public function buildModel(ModelBuilder $mb)
    {
        $mb->name('Boyhagemann\Navigation\Model\Node')->table('navigation_node')->parentClass('Baum\Node');
        
        $table = $mb->getBlueprint();
        $table->integer('parent_id')->nullable();
        $table->integer('lft')->nullable();
        $table->integer('rgt')->nullable();
        $table->integer('depth')->nullable();
    }

    /**
     * @param OverviewBuilder $ob
     */
    public function buildOverview(OverviewBuilder $ob)
    {
        $ob->fields(array('title', 'route', 'container_id'));
    }


	/**
	 * @return array
	 */
	public function config()
	{
		return array(
			'title' => 'Node',
		);
	}

}

