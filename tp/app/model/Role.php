<?php
namespace app\model;

use think\Model;

class Role extends Model{
  
	protected $schema = [
    'id'          => 'int',
    'name'        => 'varchar',
    'status'      => 'tinyint',
		'remark'  => 'varchar'
  ];

}
