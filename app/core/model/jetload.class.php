<?php 
	namespace JetPHP\Model;
	use JetPHP\Model\Format;
	class JetLoad {
		public $top = false;
		public $menu = false;
		public $footer = false;
		public $viewPath = '../app/view/';
		public $vars;

		public function view($path) {
			$path = Format::convertPoints($path);
			if (file_exists($this->viewPath.$path.'.phtml')) {
				if ($this->vars != null) {
					extract ($this->vars, EXTR_OVERWRITE);
				}
				if ($this->top != false && file_exists($this->viewPath.$this->top.'.phtml')) { include $this->viewPath.$this->top.'.phtml'; }
				if ($this->menu != false && file_exists($this->viewPath.$this->menu.'.phtml')) { include $this->viewPath.$this->menu.'.phtml'; }

				include $this->viewPath.$path.'.phtml';
				if ($this->footer != false && file_exists($this->viewPath.$this->footer.'.phtml')) { include $this->viewPath.$this->footer.'.phtml'; }
			} else {
				if (file_exists($this->viewPath.'erro/404.phtml')) {
					include $this->viewPath.'erro/404.phtml';
				}
			}
		}



		/*
		*	The view configuration $path syntax is: folder.name
		*/
		public function addVars($vars) {
			if (is_array($vars)) {
				$this->vars = $vars;
			}
		}
		public function setMenu($path) {$this->menu = Format::convertPoints($path);return $this;}
		public function setTop($path) {$this->top = Format::convertPoints($path);return $this;}
		public function setFooter($path) {$this->footer = Format::convertPoints($path);return $this;}
	}
?>
