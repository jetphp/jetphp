<?php 
	namespace JetPHP\Model;
	use JetPHP\Model\Format;
	class JetLoad {
		public $top = false;
		public $menu = false;
		public $footer = false;
		public $viewPath = '../app/view/';

		public function view($path) {
			$path = Format::convertPoints($path);
			if (file_exists($this->viewPath.$path)) {
				// View path exists
				if ($this->top != false && file_exists($this->viewPath.$this->top)) { include $this->viewPath.$this->top; }
				if ($this->menu != false && file_exists($this->viewPath.$this->menu)) { include $this->viewPath.$this->menu; }
				include $this->viewPath.$path;
				if ($this->footer != false && file_exists($this->viewPath.$this->footer)) { include $this->viewPath.$this->footer; }
			} else {
				if (file_exists($this->viewPath.'erro/404.phtml')) {
					include $this->viewPath.'erro/404.phtml';
				}
			}
		}



		/*
		*	The view configuration $path syntax is: folder.name
		*/
		public function setMenu($path) {$this->menu = Format::convertPoints($path);return $this;}
		public function setTop($path) {$this->top = Format::convertPoints($path);return $this;}
		public function setFooter($path) {$this->footer = Format::convertPoints($path);return $this;}
	}
?>
