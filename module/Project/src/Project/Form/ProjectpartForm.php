<?php
namespace Project\Form;

use Zend\Form\Form;

class ProjectpartForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('projectPart');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
        		'name' => 'master',
        		'attributes' => array(
        				'type'  => 'hidden',
        		),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
        		'name' => 'description',
        		'attributes' => array(
        				'type'  => 'textarea',
        		),
        		'options' => array(
        				'label' => 'Description',
        		),
        ));
        $this->add(array(
        		'name' => 'startdate',
        		'attributes' => array(
        				'type'  => 'date',
        		),
        		'options' => array(
        				'label' => 'Startdate',
        		        'format' => 'd.m.Y'
        		),
        ));
        $this->add(array(
        		'name' => 'enddate',
        		'attributes' => array(
        				'type'  => 'date',
        		),
        		'options' => array(
        				'label' => 'Enddate',
        		        'format' => 'd.m.Y'
        		),
        ));
        $this->add(array(
        		'name' => 'type',
        		'attributes' => array(
        				'type'  => 'hidden',
        		),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}