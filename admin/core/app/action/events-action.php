<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$a = new PostData();
	$a->title = $_POST["title"];
	$a->content = $_POST["content"];
	$a->start_at = $_POST["start_at"];
	$a->finish_at = $_POST["finish_at"];
	$a->image="";

	$img = new Upload($_FILES["image"]);
	if($img->uploaded){
		$img->Process("../storage/posts/");
		if($img->processed){
			$a->image=$img->file_dst_name;
		}
	}


	$a->kind = $_POST["kind"];
	$a->kind_pub = 2;
	$a->user_id = $_SESSION["user_id"];
	$a->add_event();
	Core::redir("./?view=events&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$a = PostData::getById($_POST["id"]);
	$a->title = $_POST["title"];
	$a->content = $_POST["content"];
	$a->start_at = $_POST["start_at"];
	$a->finish_at = $_POST["finish_at"];

	$img = new Upload($_FILES["image"]);
	if($img->uploaded){
		$img->Process("../storage/posts/");
		if($img->processed){
			$a->image=$img->file_dst_name;
		}
	}


	$a->kind = $_POST["kind"];
	$a->update_event();
	Core::redir("./?view=events&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = PostData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=events&opt=all");
}

?>