<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Project for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Project\Controller;

use Zend\View\Model\ViewModel;

class ProjectController extends ProjectpartController
{
    public function indexAction()
    {
    	return new ViewModel(array(
    			'projectparts' => $this->getProjectPartTable()->fetchAll('project'),
    	));
    }
}
