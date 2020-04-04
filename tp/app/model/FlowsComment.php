<?php
namespace app\model;

use think\Model;

use think\facade\Session;

class FlowsComment extends Model{
  
	protected $schema = [
		'id' => 'int',
		'name' => 'varchar',
		'datetime' => 'datetime',
		'comment' => 'text',
		'flow_id' => 'int',
		'username' => 'varchar',
		'department' => 'varchar',
		'post' => 'varchar'
	];

	public  function add_one(string $comment,int $flowId){
		
		$userinfo = Session::get('userinfo');
		$comment = array(
			'name' => $userinfo['name'],
			'username' => $userinfo['username'],
			'datetime' => date('Y-m-d H:i:s',time()),
			'comment' => $comment,
			'flow_id' => $flowId,
			'post' => $userinfo['post'],
			'department' => $userinfo['department']
		);

		$this->create($comment);

		
	}

	

	

}
