<?php
namespace Project\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class ProjectpartTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll($type = 'project')
	{
		$resultSet = $this->tableGateway->select(array('type' => $type));
		return $resultSet;
	}

	public function getProjectPart($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveProjectPart(ProjectPart $projectPart)
	{
		$data = array(
				'id' => $projectPart->id,
				'name'  => $projectPart->name,
				'description'  => $projectPart->description,
		        'startdate'  => $projectPart->startdate,
		        'enddate'  => $projectPart->enddate,
		        'type' => $projectPart->type,
		        'master' => $projectPart->master
		);

		$id = (int)$projectPart->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getProjectPart($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
	}

	public function deleteProjectPart($id)
	{
		$this->tableGateway->delete(array('id' => $id));
	}
	
	public function getChildren($id) {
	    $children = array();
	    $adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
        $select = $sql->select();
	    $select->from('projectpart');
	   // $select->join('projectpart', 'projectpart.id = projectpart.master');
	    
	    $select->where(array('master' => $id));
	    $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        
        foreach ($results as $result) {
        	$children[] = $this->getProjectPart($result->id);
        }
	    
	    return $children;
	}

}