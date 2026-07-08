<?php

if (isset($_GET["opt"]) && $_GET["opt"] == "add") {
	$a = new CoursesData();
	$a->name = $_POST["name"];
	$a->url = $_POST["url"];
	$a->kind = $_POST["kind"];
	$a->date = $_POST["date"];
	$a->star = $_POST["star"];
	$a->end = $_POST["end"];
	$a->add();

	Core::redir("./?view=courses&opt=all");
} else if (isset($_GET["opt"]) && $_GET["opt"] == "update") {
	$a = CoursesData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->url = $_POST["url"];
	$a->kind = $_POST["kind"];
	$a->date = $_POST["date"];
	$a->star = $_POST["star"];
	$a->end = $_POST["end"];
	$a->update();
	Core::redir("./?view=courses&opt=all");
} else if (isset($_GET["opt"]) && $_GET["opt"] == "del") {
	$a = CoursesData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=courses&opt=all");
} else if (isset($_GET["opt"]) && $_GET["opt"] == "delperson") {
	$id_person = $_GET["id_person"];
	$id_course = $_GET["id_course"];
	$a = RegCourses::getByIdPersonCourse($id_person,$id_course);
	$a -> person = $id_person;
	$a -> course = $id_course;
	$a->delperson();
	Core::redir("./?view=courses&opt=view&id=$id_course");
} else if (isset($_GET["opt"]) && $_GET["opt"] == "check") {
	$a = CoursesData::getById($_GET["id"]);
	$a->is_active = 0;
	$a->updatestatus();
	Core::redir("./?view=courses&opt=all");
}
