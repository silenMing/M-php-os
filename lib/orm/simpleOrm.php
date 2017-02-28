<?php 
abstract class ActiveRecord{

	protected static $table;
	protected static $fileter;
	protected $select;

	static function find($id){
	    $query = "select * from ".static::$table." where id = $id";

	    return self::createDomain($query);
    }

    static  function callStatic($method,$args){
        $filed = preg_replace('/^findBy(\w*)$/','${1}',$method);

        $query= "select * from ".static::$table." where $filed =$args";

        return self::createDomain($query);
    }

    function get($filename){
        return $this->fieldvalues[$filename];
    }


    private static function createDomain($query){
	    $getclass = get_called_class();
	    $domain = new $getclass;

	    $domain->fieldvalues = array();

	    $domain->select = $query;

	    foreach ($getclass as $filed =>$type){
                $domain->fieldvalues[$filed] = '';
        }
        return $domain;
    }



}