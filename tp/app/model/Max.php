<?php
declare(strict_types=1);
namespace app\model;

use think\Model;

class Max extends Model{
  
	protected $schema = [
		'id' => 'int',
		'type' => 'varchar',
		'f' => 'int',
		's' => 'int',
		'length' => 'int',
		'prev' => 'varchar'
	];


	public function get_max():array{
		$tmp = $this->where(" type = 'flow_table'")->field('f,s')->find()->toArray();
		$tmp['f']++;
		$tmp['s']++;
		return $tmp;

	}

	public function set_max(string $type,int $f, int $s):void{
		$t = $this->where("type = '".$type."'")->find();
		$t->f += $f;
		$t->s += $s;
		$t->save();
	}



	

}
