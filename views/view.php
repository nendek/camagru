<?php

class View {

	private $file;
	private $title;

	public function __construct($action) {
		$this->file = "views/view_" . $action . ".php";
	}

	public function generate($data) {
		$contenu = $this->generateFile($this->file, $data);
		$view = $this->generateFile('views/template.php', array('title' => $this->title, 'content' => $content));
		echo $view;
	}

	private function generateFile($file, $data) {
		if (file_exists($file)) {
			extract($data);
			ob_start();
			require $file;
			return ob_get_clean();
		}
		else {
			throw new Exception("file '$file' introuvable");
		}
	}
}

?>
