<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Project for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Project\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Project\Model\ProjectPart;          
use Project\Form\ProjectPartForm;

class ProjectpartController extends AbstractActionController
{
    protected $projectPartTable;
    
    public function indexAction()
    {
        return new ViewModel(array(
            'projectparts' => $this->getProjectPartTable()->fetchAll(),
        ));
    }
    
 public function showAction() {
     $id = (int) $this->params()->fromRoute('id', 0);
     if (!$id) {
     	return $this->redirect()->toRoute('projectpart', array(
     			'action' => 'add'
     	));
     }
     $projectpart = $this->getProjectPartTable()->getProjectPart($id);
     
     $children = $this->getProjectPartTable()->getChildren($id);
     
     $form  = new ProjectPartForm();
     $form->bind($projectpart);
     $form->get('submit')->setAttribute('value', 'Back');
    
     return array(
     		'id' => $id,
     		'form' => $form,
            'projectpart' => $projectpart,
            'children' => $children
     );
 }
    
 public function addAction()
    {
        $master = (int) $this->params()->fromRoute('id', 0);
        $form = new ProjectPartForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $projectpart = new ProjectPart();
            $form->setInputFilter($projectpart->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $projectpart->exchangeArray($form->getData());
                $this->getProjectPartTable()->saveProjectPart($projectpart);
                
                return $this->redirect()->toRoute('project');
            }
        }
        return array('form' => $form, 'master' => $master);
    }
    
public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('projectpart', array(
                'action' => 'add'
            ));
        }
        $projectpart = $this->getProjectPartTable()->getProjectPart($id);

        $form  = new ProjectPartForm();
        $form->bind($projectpart);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($projectpart->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getProjectPartTable()->saveProjectPart($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('projectpart');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
 public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('projectpart');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getProjectPartTable()->deleteProjectPart($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('projectpart');
        }

        return array(
            'id'    => $id,
            'project' => $this->getProjectPartTable()->getProjectPart($id)
        );
    }

 public function getProjectPartTable()
    {
    	if (!$this->projectPartTable) {
    		$sm = $this->getServiceLocator();
    		$this->projectPartTable = $sm->get('Project\Model\ProjectPartTable');
    	}
    	return $this->projectPartTable;
    }
    
}
