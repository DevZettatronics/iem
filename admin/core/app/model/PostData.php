<?php
class PostData {
	public static $tablename = "post";


	public function PostData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (title,content,image,kind,kind_pub,user_id,created_at) ";
		$sql .= "value (\"$this->title\",\"$this->content\",\"$this->image\",\"$this->kind\",\"$this->kind_pub\",$this->user_id,NOW())";
		return Executor::doit($sql);
	}

	public function add_event(){
		$sql = "insert into ".self::$tablename." (start_at,finish_at,title,content,image,kind,kind_pub,user_id,created_at) ";
		$sql .= "value (\"$this->start_at\",\"$this->finish_at\",\"$this->title\",\"$this->content\",\"$this->image\",\"$this->kind\",\"$this->kind_pub\",$this->user_id,NOW())";
		return Executor::doit($sql);
	}


	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto PostData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set title=\"$this->title\",content=\"$this->content\",image=\"$this->image\",kind=\"$this->kind\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_event(){
		$sql = "update ".self::$tablename." set start_at=\"$this->start_at\",finish_at=\"$this->finish_at\",title=\"$this->title\",content=\"$this->content\",image=\"$this->image\",kind=\"$this->kind\" where id=$this->id";
		Executor::doit($sql);
	}



	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PostData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}

	public static function getAllByQ($q){
		$sql = "select * from ".self::$tablename." ".$q;
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}


	public static function getAllByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}

	public static function getFavoritesByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}

	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}


}

?>