<?php
  class Upload {
    private $file, $filename, $filepath, $mimes, $allowed_extensions, $tmp_file, $ext, $filetype;

    public function __construct($file = '') {
      $this->mimes = new \Mimey\MimeTypes;
      if ($file != '') {
        $this->file = $file;
        $this->tmp_file = $file['tmp_name'];
        $this->filetype = $file['type'];
        $this->allowed_extensions = [];

        $this->ext = strchr($file['name'],".");
        $this->filename = str_replace($this->ext,'',$file['name']);

        return $this;
      } else {
        echo "File can't be empty!";
      }
    }

    public function setFilename($name) {
      if (is_array($this->file)) {
        $this->filename = $name;
      } else {
        echo "File not found for setting name.";
      }
      return $this;
    }

    public function setFilepath($path) {
      if (is_array($this->file)) {
        $this->filepath = $path;
      } else {
        echo "File not found for setting path.";
      }
      return $this;
    }

    // Parameter can be a string or an array.
    public function addExtensions($ext='') {
      if ($ext != '') {
        if (is_array($ext)) {
          // Array
          foreach ($ext as $name) {
            $name = str_replace('.','',$name);
            $this->allowed_extensions[$name] = $this->mimes->getMimeType($name);
          }

        } else {
          // Var
          $ext = str_replace('.','',$ext);
          $this->allowed_extensions[$ext] = $this->mimes->getMimeType($ext);
        }
      } else {
        echo "Parameters can't be empty.";
      }
      return $this;
    }

    public function sendFile() {
      if ($this->checkUpload()) {
        if (move_uploaded_file($this->tmp_file, $this->generateCompletePath())) {
          return ['status'=>'success', 'msg'=>'File uploaded as '.$this->generateCompletePath().'!'];
        }
      } else {
        // Extension error
        return ['status'=>'error', 'msg'=>'Please check the extension and type of your file.'];
      }
    }

    private function checkUpload() {
      $ext  = str_replace('.','',$this->ext);

      if (isset($this->allowed_extensions[$ext]) and $this->allowed_extensions[$ext] == $this->filetype) {
        return true;
      } else {
        return false;
      }
    }

    private function generateCompletePath() {
      $path = $this->filepath.'/';
      $name = $this->filename;
      $ext  = $this->ext; // . included

      return $path.$name.$ext;
    }

  }
?>
