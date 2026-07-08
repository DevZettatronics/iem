<?php
session_start();

$_SESSION['dirini']='./'.$_SESSION['directorio'];
//$_SESSION['dirini']="./Prueba_Datos";

class DirectoryListing {
	//public $startDirectory = './x';
	public $pageTitle = 'Expediente Digital Docente';
	public $includeUrl = false;
	public $directoryUrl = 'https://viserion.gestalt.education/teacher/core/app/das_schwarze_lagerhaus/';
	public $showSubDirectories = true;
	public $openLinksInNewTab = true;
	public $showThumbnails = true;
	public $enableDirectoryCreation = true;
	public $enableUploads = true;
	public $enableMultiFileUploads = true;
	public $overwriteOnUpload = false;
	public $enableFileDeletion = true;
	public $enableDirectoryDeletion = true;
	public $allowedUploadMimeTypes = array(
		'image/jpeg',
		'image/gif',
		'image/png',
		'image/bmp',
		'audio/mpeg',
		'audio/mp3',
		'audio/mp4',
		'audio/x-aac',
		'audio/x-aiff',
		'audio/x-ms-wma',
		'audio/midi',
		'audio/ogg',
		'video/ogg',
		'video/webm',
		'video/quicktime',
		'video/x-msvideo',
		'video/x-flv',
		'video/h261',
		'video/h263',
		'video/h264',
		'video/jpeg',
		'text/plain',
		'text/html',
		'text/css',
		'text/csv',
		'text/calendar',
		'application/pdf',
		'application/x-pdf',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // MS Word (moderno)
		'application/msword',
		'application/vnd.ms-excel',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // MS Excel (moderno)
		'application/zip',
		'application/x-tar'
	);

	public $enableUnzipping = true;
	public $deleteZipAfterUploading = false;
	public $enableTheme = true;
	public $passwordProtect = false;
	public $password = 'password';
	public $enableIpWhitelist = false;
	public $ipWhitelist = array(
		'127.0.0.1'
	);
	public $ignoredFileExtensions = array(
		'php',
		'ini',
	);
	public $ignoredFileNames = array(
		'.htaccess',
		'.DS_Store',
		'Thumbs.db',
		'estilos.css',
		'estilo_carga.css',
	);
	public $ignoredDirectories = array(
        ' ',
	);
	public $ignoreDotFiles = true;
	public $ignoreDotDirectories = true;
	private $__previewMimeTypes = array(
		'image/gif',
		'image/jpeg',
		'image/png',
		'image/bmp'
	);

	private $__currentDirectory = null;

	private $__fileList = array();

	private $__directoryList = array();

	private $__debug = true;

	public $sortBy = 'name';

	public $sortableFields = array(
		'name',
		'size',
		'modified'
	);

	private $__sortOrder = 'asc';

	public function __construct() {
		define('DS', '/');
	}

	public function run() {
		if ($this->enableIpWhitelist) {
			$this->__ipWhitelistCheck();
		}
		//$this->__currentDirectory = $this->startDirectory;
		$this->__currentDirectory = $_SESSION['dirini'];
		if (isset($_GET['order']) && in_array($_GET['order'], $this->sortableFields)) {
			$this->sortBy = $_GET['order'];
		}
		/*echo "Este es this en run ".$this->__currentDirectory;
		echo "<br>";
		echo "Este es this 2 en run ".$this->$_SESSION['dirini'];
        echo "Este es this en run ".$this;*/
		if (isset($_GET['sort']) && ($_GET['sort'] == 'asc' || $_GET['sort'] == 'desc')) {
			$this->__sortOrder = $_GET['sort'];
		}

		if (isset($_GET['dir'])) {
			if (isset($_GET['delete']) && $this->enableDirectoryDeletion) {
				$this->deleteDirectory();
			}

			$this->__currentDirectory = $_GET['dir'];
			return $this->__display();
		} elseif (isset($_GET['preview'])) {
			$this->__generatePreview($_GET['preview']);
		} else {
			return $this->__display();
		}
	}

	public function login() {
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

		if ($password === $this->password) {
			$_SESSION['evdir_loggedin'] = true;
			unset($_SESSION['evdir_loginfail']);
		} else {
			$_SESSION['evdir_loginfail'] = true;
			unset($_SESSION['evdir_loggedin']);

		}
	}

	public function upload() {
		$files = $this->__formatUploadArray($_FILES['upload']);

		if ($this->enableUploads) {
			if ($this->enableMultiFileUploads) {
				foreach ($files as $file) {
					$status = $this->__processUpload($file);
				}
			} else {
				$file = $files[0];
				$status = $this->__processUpload($file);
			}

			return $status;
		}
		return false;
	}

	private function __formatUploadArray($files) {
		$fileAry = array();
		$fileCount = count($files['name']);
		$fileKeys = array_keys($files);

		for ($i = 0; $i < $fileCount; $i++) {
			foreach ($fileKeys as $key) {
				$fileAry[$i][$key] = $files[$key][$i];
			}
		}

		return $fileAry;
	}

	private function __processUpload($file) {
		if (isset($_GET['dir'])) {
			$this->__currentDirectory = $_GET['dir'];
		}

		if (! $this->__currentDirectory) {
			//$filePath = realpath($this->startDirectory);
			$filePath = realpath($_SESSION['dirini']);
		} else {
			$this->__currentDirectory = str_replace('..', '', $this->__currentDirectory);
			$this->__currentDirectory = ltrim($this->__currentDirectory, "/");
			$filePath = realpath($this->__currentDirectory);
		}

		$filePath = $filePath . DS . $file['name'];
        //echo "Este es filePath en processupload: ".$filePath;
		if (! empty($file)) {

			if (! $this->overwriteOnUpload) {
				if (file_exists($filePath)) {
					return 2;
				}
			}

			if (! in_array(mime_content_type($file['tmp_name']), $this->allowedUploadMimeTypes)) {
				return 3;
			}

			move_uploaded_file($file['tmp_name'], $filePath);

			if (mime_content_type($filePath) == 'application/zip' && $this->enableUnzipping && class_exists('ZipArchive')) {

				$zip = new ZipArchive;
				$result = $zip->open($filePath);
				$zip->extractTo(realpath($this->__currentDirectory));
				$zip->close();

				if ($this->deleteZipAfterUploading) {
					unlink($filePath);
				}


			}

			return true;
		}
	}

	public function deleteFile() {
		if (isset($_GET['deleteFile'])) {
			$file = $_GET['deleteFile'];

			$file = str_replace('..', '', $file);
			$file = ltrim($file, "/");

			$filePath = __DIR__ . $this->__currentDirectory . '/' . $file;

			if (file_exists($filePath) && is_file($filePath)) {
				return unlink($filePath);
			}
			return false;
		}
	}

	public function deleteDirectory() {
		if (isset($_GET['dir'])) {
			$dir = $_GET['dir'];
			$dir = str_replace('..', '', $dir);
			$dir = ltrim($dir, "/");

			$dirPath = __DIR__ . '/' . $dir;

			if (file_exists($dirPath) && is_dir($dirPath)) {

				$iterator = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
				$files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);

				foreach ($files as $file) {
					if ($file->isDir()) {
						rmdir($file->getRealPath());
					} else {
						unlink($file->getRealPath());
					}
				}
				return rmdir($dir);
			}
		}
		return false;
	}

	public function createDirectory() {
		if ($this->enableDirectoryCreation) {
			$directoryName = $_POST['directory'];

			$directoryName = str_replace(' ', '_', $directoryName);

			$directoryName = preg_replace('/[^\w-_]/', '', $directoryName);

			if (isset($_GET['dir'])) {
				$this->__currentDirectory = $_GET['dir'];
			    //$this->__currentDirectory = $_SESSION['dirini'];
			}

			if (! $this->__currentDirectory) {
				$filePath = realpath($_SESSION['dirini']);
				//$filePath = realpath($this->startDirectory);
				//echo "Este es filepath en createdirectory: ".$filePath;
			} else {
				$this->__currentDirectory = str_replace('..', '', $this->__currentDirectory);
				$filePath = realpath($this->__currentDirectory);
				//$filePath = realpath($_SESSION['dirini']);
			}

			$filePath = $filePath . DS . strtolower($directoryName);

			if (file_exists($filePath)) {
				return false;
			}

			return mkdir($filePath, 0755);

		}
		return false;
	}

	public function sortUrl($sort) {

		$urlParts = parse_url($_SERVER['REQUEST_URI']);

		$url = '';

		if (isset($urlParts['scheme'])) {
			$url = $urlParts['scheme'] . '://';
		}

		if (isset($urlParts['host'])) {
			$url .= $urlParts['host'];
		}

		if (isset($urlParts['path'])) {
			$url .= $urlParts['path'];
		}


		if (isset($urlParts['query'])) {
			$queryString = $urlParts['query'];

			parse_str($queryString, $queryParts);

			if (isset($queryParts['order']) && $queryParts['order'] == $sort) {

				if (isset($queryParts['sort'])) {
					if ($queryParts['sort'] == 'asc') {
						$queryParts['sort'] = 'desc';
					} else {
						$queryParts['sort'] = 'asc';
					}
				}
			} else {
				$queryParts['order'] = $sort;
				$queryParts['sort'] = 'asc';
			}

			$queryString = http_build_query($queryParts);

			$url .= '?' . $queryString;
		} else {
			$order = 'asc';
			if ($sort == $this->sortBy) {
				$order = 'desc';
			}
			$queryString = 'order=' . $sort . '&sort=' . $order;
			$url .= '?' . $queryString;
		}

		return $url;
	}

	public function sortClass($sort) {
		$class = $sort . '_';

		if ($this->sortBy == $sort) {
			if ($this->__sortOrder == 'desc') {
				$class .= 'desc sort_desc';
			} else {
				$class .= 'asc sort_asc';
			}
		} else {
			$class = '';
		}
		return $class;
	}

	private function __ipWhitelistCheck() {
		$userIp = $_SERVER['REMOTE_ADDR'];

		if (! in_array($userIp, $this->ipWhitelist)) {
			header('HTTP/1.0 403 Forbidden');
			die('Your IP address (' . $userIp . ') is not authorized to access this file.');
		}
	}

	private function __display() {
		if ($this->__currentDirectory != '.' && !$this->__endsWith($this->__currentDirectory, DS)) {
			$this->__currentDirectory = $this->__currentDirectory . DS;
		}

		return $this->__loadDirectory($this->__currentDirectory);
	}

	private function __loadDirectory($path) {
		$files = $this->__scanDir($path);

		if (! empty($files)) {
			$files = $this->__cleanFileList($files);
			foreach ($files as $file) {
				$filePath = realpath($this->__currentDirectory . DS . $file);

				if ($this->__isDirectory($filePath)) {

					if (! $this->includeUrl) {
						$urlParts = parse_url($_SERVER['REQUEST_URI']);

						$dirUrl = '';

						if (isset($urlParts['scheme'])) {
							$dirUrl = $urlParts['scheme'] . '://';
						}

						if (isset($urlParts['host'])) {
							$dirUrl .= $urlParts['host'];
						}

						if (isset($urlParts['path'])) {
							$dirUrl .= $urlParts['path'];
						}
					} else {
						$dirUrl = $this->directoryUrl;
					}

					if ($this->__currentDirectory != '' && $this->__currentDirectory != '.') {
						$dirUrl .= '?dir=' . rawurlencode($this->__currentDirectory) . rawurlencode($file);
					} else {
						$dirUrl .= '?dir=' . rawurlencode($file);
					}

					$this->__directoryList[$file] = array(
						'name' => rawurldecode($file),
						'path' => $filePath,
						'type' => 'dir',
						'url' => $dirUrl
					);
				} else {
					$this->__fileList[$file] = $this->__getFileType($filePath, $this->__currentDirectory . DS . $file);
				}
			}
		}

		if (! $this->showSubDirectories) {
			$this->__directoryList = null;
		}

		$data = array(
			'currentPath' => $this->__currentDirectory,
			'directoryTree' => $this->__getDirectoryTree(),
			'files' => $this->__setSorting($this->__fileList),
			'directories' => $this->__directoryList,
			'requirePassword' => $this->passwordProtect,
			'enableUploads' => $this->enableUploads
		);

		return $data;
	}

	private function __setSorting($data) {
		$sortOrder = '';
		$sortBy = '';

		if ($this->sortBy == 'name') {
			function compareByName($a, $b) {
				return strnatcasecmp($a['name'], $b['name']);
			}

			usort($data, 'compareByName');
			$this->soryBy = 'name';
		} elseif ($this->sortBy == 'size') {
			function compareBySize($a, $b) {
				return strnatcasecmp($a['size_bytes'], $b['size_bytes']);
			}

			usort($data, 'compareBySize');
			$this->soryBy = 'size';
		} elseif ($this->sortBy == 'modified') {
			function compareByModified($a, $b) {
				return strnatcasecmp($a['modified'], $b['modified']);
			}

			usort($data, 'compareByModified');
			$this->soryBy = 'modified';
		}

		if ($this->__sortOrder == 'desc') {
			$data = array_reverse($data);
		}
		return $data;
	}

	private function __scanDir($dir) {
		if (strstr($dir, '../')) {
			return false;
		}

		if ($dir == '/') {
			
			//$dir = $this->startDirectory;
			$dir =$_SESSION['dirini'];
			//echo "Este es dir en scandir: ".$dir;
			$this->__currentDirectory = $dir;
			//echo "Este es this en scandir".$this;
		}

		$strippedDir = str_replace('/', '', $dir);

		$dir = ltrim($dir, "/");

		if (in_array($strippedDir, $this->ignoredDirectories)) {
			return false;
		}

		if (! file_exists($dir) || !is_dir($dir)) {
			return false;
		}

		return scandir($dir);
	}

	private function __cleanFileList($files) {
		$this->ignoredDirectories[] = '.';
		$this->ignoredDirectories[] = '..';
		foreach ($files as $key => $file) {

			if ($this->__isDirectory(realpath($file)) && in_array($file, $this->ignoredDirectories)) {
				unset($files[$key]);
			}

			if ($this->ignoreDotDirectories && substr($file, 0, 1) === '.') {
				unset($files[$key]);
			}

			if (! $this->__isDirectory(realpath($file)) && in_array($file, $this->ignoredFileNames)) {
				unset($files[$key]);
			}
			if (! $this->__isDirectory(realpath($file))) {

				$info = pathinfo(mb_convert_encoding($file, 'UTF-8', 'UTF-8'));

				if (isset($info['extension'])) {
					$extension = $info['extension'];

					if (in_array($extension, $this->ignoredFileExtensions)) {
						unset($files[$key]);
					}
				}

				if ($this->ignoreDotFiles) {

					if (substr($file, 0, 1) == '.') {
						unset($files[$key]);
					}
				}
			}
		}
		return $files;
	}

	private function __isDirectory($file) {
		if ($file == $this->__currentDirectory . DS . '.' || $file == $this->__currentDirectory . DS . '..') {
			return true;
		}
		$file = mb_convert_encoding($file, 'UTF-8', 'UTF-8');

		if (filetype($file) == 'dir') {
			return true;
		}

		return false;
	}

	private function __getFileType($filePath, $relativePath = null) {
		$fi = new finfo(FILEINFO_MIME_TYPE);

		if (! file_exists($filePath)) {
			return false;
		}

		$type = $fi->file($filePath);

		$filePathInfo = pathinfo($filePath);

		$fileSize = filesize($filePath);

		$fileModified = filemtime($filePath);

		$filePreview = false;

		if ($this->__supportsPreviews($type) && $this->showThumbnails) {
			$filePreview = true;
		}

		return array(
			'name' => $filePathInfo['basename'],
			'extension' => (isset($filePathInfo['extension']) ? $filePathInfo['extension'] : null),
			'dir' => $filePathInfo['dirname'],
			'path' => $filePath,
			'relativePath' => $relativePath,
			'size' => $this->__formatSize($fileSize),
			'size_bytes' => $fileSize,
			'modified' => $fileModified,
			'type' => 'file',
			'mime' => $type,
			'url' => $this->__getUrl($filePathInfo['basename']),
			'preview' => $filePreview,
			'target' => ($this->openLinksInNewTab ? '_blank' : '_parent')
		);
	}

	private function __supportsPreviews($type) {
		if (in_array($type, $this->__previewMimeTypes)) {
			return true;
		}
		return false;
	}

	private function __getUrl($file) {
		if (! $this->includeUrl) {
			$dirUrl = $_SERVER['REQUEST_URI'];

			$urlParts = parse_url($_SERVER['REQUEST_URI']);

			$dirUrl = '';

			if (isset($urlParts['scheme'])) {
				$dirUrl = $urlParts['scheme'] . '://';
			}

			if (isset($urlParts['host'])) {
				$dirUrl .= $urlParts['host'];
			}

			if (isset($urlParts['path'])) {
				$dirUrl .= $urlParts['path'];
			}
		} else {
			$dirUrl = $this->directoryUrl;
		}

		if ($this->__currentDirectory != '.') {
			$dirUrl = $dirUrl . $this->__currentDirectory;
		}
		return $dirUrl . rawurlencode($file);
	}

	private function __getDirectoryTree() {
		$dirString = $this->__currentDirectory;
		$directoryTree = array();

		$directoryTree['./'] = 'Index';

		if (substr_count($dirString, '/') >= 0) {
			$items = explode("/", $dirString);
			$items = array_filter($items);
			$path = '';
			foreach ($items as $item) {
				if ($item == '.' || $item == '..') {
					continue;
				}
				$path .= rawurlencode($item) . '/';
				$directoryTree[$path] = $item;
			}
		}

		$directoryTree = array_filter($directoryTree);

		return $directoryTree;
	}

	private function __endsWith($haystack, $needle) {
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}

	private function __generatePreview($filePath) {
		$file = $this->__getFileType($filePath);

		if ($file['mime'] == 'image/jpeg') {
			$image = imagecreatefromjpeg($file['path']);
		} elseif ($file['mime'] == 'image/png') {
			$image = imagecreatefrompng($file['path']);
		} elseif ($file['mime'] == 'image/gif') {
			$image = imagecreatefromgif($file['path']);
		} else {
			die();
		}

		$oldX = imageSX($image);
		$oldY = imageSY($image);

		$newW = 250;
		$newH = 250;

		if ($oldX > $oldY) {
			$thumbW = $newW;
			$thumbH = $oldY * ($newH / $oldX);
		}
		if ($oldX < $oldY) {
			$thumbW = $oldX * ($newW / $oldY);
			$thumbH = $newH;
		}
		if ($oldX == $oldY) {
			$thumbW = $newW;
			$thumbH = $newW;
		}

		header('Content-Type: ' . $file['mime']);

		$newImg = ImageCreateTrueColor($thumbW, $thumbH);

		imagecopyresampled($newImg, $image, 0, 0, 0, 0, $thumbW, $thumbH, $oldX, $oldY);

		if ($file['mime'] == 'image/jpeg') {
			imagejpeg($newImg);
		} elseif ($file['mime'] == 'image/png') {
			imagepng($newImg);
		} elseif ($file['mime'] == 'image/gif') {
			imagegif($newImg);
		}
		imagedestroy($newImg);
		die();
	}

	private function __formatSize($bytes) {
		$units = array('B', 'KB', 'MB', 'GB', 'TB');

		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		$bytes /= pow(1024, $pow);

		return round($bytes, 2) . ' ' . $units[$pow];
	}

}

$listing = new DirectoryListing();

$successMsg = null;
$errorMsg = null;

if (isset($_POST['password'])) {
	$listing->login();

	if (isset($_SESSION['evdir_loginfail'])) {
		$errorMsg = 'Inicio fallido. Por favor intente nuevamente.';
		unset($_SESSION['evdir_loginfail']);
	}

} elseif (isset($_FILES['upload'])) {
	$uploadStatus = $listing->upload();
	if ($uploadStatus == 1) {
		$successMsg = 'Tu archivo han sido cargados';
	} elseif ($uploadStatus == 2) {
		$errorMsg = 'Tu archivo no puede ser subido. Ya existe un archivo con el mismo nombre.';
	} elseif ($uploadStatus == 3) {
		$errorMsg = 'Tu archivo no pueden ser subido. El tipo de extensión del archivo no es permitido.';
	}
} elseif (isset($_POST['directory'])) {
	if ($listing->createDirectory()) {
		$successMsg = 'El directorio ha sido creado';
	} else {
		$errorMsg = 'Tenemos problemas para crear su directorio, por favor intente nuevamente.';
	}
} elseif (isset($_GET['deleteFile']) && $listing->enableFileDeletion) {
	if ($listing->deleteFile()) {
		$successMsg = 'Su archivo fue eliminado exitosamente.';
	} else {
		$errorMsg = 'El archivo seleccionado no puede ser borrado. Por favor revisa los permisos del archivo e intenta nuevamente.';
	}
} elseif (isset($_GET['dir']) && isset($_GET['delete']) && $listing->enableDirectoryDeletion) {
	if ($listing->deleteDirectory()) {
		$successMsg = 'El directorio ha sido eliminado.';
		unset($_GET['dir']);
	} else {
		$errorMsg = 'El directorio seleccionado no puede ser borrado, por favor cheque sus permisos e intenete nuevamente.';
	}
}

$data = $listing->run();

function pr($data, $die = false) {
	echo '<pre>';
	print_r($data);
	echo '</pre>';

	if ($die) {
		die();
	}
}

?>