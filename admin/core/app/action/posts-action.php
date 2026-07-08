<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$a = new PostData();
	$a->title = $_POST["title"];
	$a->content = $_POST["content"];
	$a->image="";
	$a->pdf="";

	$img = new Upload($_FILES["image"]);
	if($img->uploaded){
		$img->Process("../storage/posts/");
		if($img->processed){
			$a->image=$img->file_dst_name;
		}
	}

	
	$pdf = new Upload($_FILES["pdf"]);
	if($pdf->uploaded){
		$pdf->Process("../storage/pdf/");
		if($pdf->processed){
			$a->pdf=$pdf->file_dst_name;
		}
	}
	

	$a->kind = $_POST["kind"];
	$a->kind_pub = 1;
	$a->user_id = $_SESSION["user_id"];
	$a->add();
	Core::redir("./?view=posts&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$a = PostData::getById($_POST["id"]);
	$a->title = $_POST["title"];
	$a->content = $_POST["content"];

	$img = new Upload($_FILES["image"]);
	if($img->uploaded){
		$img->Process("../storage/posts/");
		if($img->processed){
			$a->image=$img->file_dst_name;
		}
	}

	$pdf = new Upload($_FILES["pdf"]);
	if($pdf->uploaded){
		$pdf->Process("../storage/pdf/");
		if($pdf->processed){
			$a->pdf=$pdf->file_dst_name;
		}
	}

	$a->kind = $_POST["kind"];
	$a->update();
	Core::redir("./?view=posts&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = PostData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=posts&opt=all");
}

?>