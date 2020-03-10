<?php
    // Helper class for setting stylesheets and scripts
    Class Header {
        private $title;
        private $scripts=array();
        private $styles=array();
        private $authors=array();


        private $default_scripts = array(
            'jquery.min',
            'bootstrap.min',
            'popper.min',
            'toast',
            'functions'
        );
        private $default_styles = array(
            'bootstrap.min'
        );

        const APPNAME = 'BPLS';

        /*
         * Fill properties with values for printing into the head of html.
         * @param array
         * return Header Object
         */
        public function __construct($param = array()) {
            // Add authors
            global $config;
            $this->authors = $config['authors'];

            // Checking if default files are added.
            // This allows creation of headers without having to
            // manually provide the file names of scripts and
            // styles we always use in every document.
            // Scripts
            foreach($this->default_scripts as $script_name) {
                if(!in_array($script_name, $this->scripts)) {
                    $this->scripts[] = $script_name;
                }
            }
            // Styles
            foreach($this->default_styles as $style_name) {
                if(!in_array($style_name, $this->styles)) {
                    $this->styles[] = $style_name;
                }
            }

            // Setting properties from passed values
            if(empty($param['title'])) {
                $this->title = $config['title']['abbv'];
            }
            else {
                $this->title = $param['title'];
            }
            // Set Scripts
            if(isset($param['scripts'])) {
                foreach($param['scripts'] as $script) {
                    $this->scripts[] = $script;
                }
            }
            // Set Styles
            if(isset($param['styles'])) {
                foreach($param['styles'] as $style) {
                    $this->styles[] = $style;
                }
            }

            return $this;
        }

        public function __get($name) {
            return $this->$name;
        }

        public function loadStyle($styles = array()) {
            if(is_array($styles)) {
                foreach($styles as $style_name) {
                    $this->styles[] = $style_name;
                }
            }
            else {
                $this->styles[] = $styles;
            }
        }

        public function addScripts($scripts = array()) {
            if(is_array($scripts)) {
                foreach($scripts as $script_name) {
                    $this->scripts[] = $script_name;
                }
            }
            else {
                $this->scripts[] = $scripts;
            }
        }

        public function setHead() {
            $output = '<head>';
            // Title
            $output .= '<title>';
                $output .= htmlentities($this->title . ' | '.self::APPNAME);
            $output .= '</title>';

            // Meta Data
            $output .= '<meta charset="utf-8">';
            $output .= '<meta name="author" content="'.join(', ', $this->authors).'">';
            $output .= '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
            $output .= '<meta name="description" content="">';
            // Styles
            foreach($this->styles as $style_name) {
                $path = 'assets'.DS.'css'.DS.$style_name.'.css';
                $su_path = '..'.DS.'assets'.DS.'css'.DS.$style_name.'.css';
                if(file_exists($path)) {
                    $output .= '<link type="text/css" rel="stylesheet" href="'.$path.'" />';
                }
                else if(file_exists($su_path)) {
                    $output .= '<link type="text/css" rel="stylesheet" href="'.$su_path.'" />';
                }
                else {
                    trigger_error('Cannot load '.$style_name.'.css.');
                }
            }
            $output .= '</head>';

            return $output;
        }

        public function loadScripts($scripts = array()) {
            $output = '';
            // Check if there are passed parameters.
            if(!empty($scripts) && is_array($scripts)) {
                // Script/s was passed as an array.
                foreach($scripts as $script) {
                    $this->scripts[] = $script;
                }
            }
            else if(!empty($scripts)) {
                // Script was passed as a string.
                $this->scripts[] = $scripts;
            }
            // Scripts
            foreach($this->scripts as $script_name) {
                $path = 'assets'.DS.'js'.DS.$script_name.'.js';
                $su_path = '..'.DS.'assets'.DS.'js'.DS.$script_name.'.js';
                if(file_exists($path)) {
                    $output .= '<script type="text/javascript" src="'.$path.'"></script>';
                }
                else if(file_exists($su_path)) {
                    $output .= '<script type="text/javascript" src="'.$su_path.'"></script>';
                }
                else {
                    trigger_error('Cannot load <b>'.$path.'</b>.');
                    return;
                }
            }
            $output .= '<script type="text/javascript">';
            $nav_path = '';
            if(file_exists('assets'.DS.'js'.DS.'navbar.js')) {
                $nav_path = 'assets'.DS.'js'.DS.'navbar.js';
            }
            else if(file_exists('..'.DS.'assets'.DS.'js'.DS.'navbar.js')) {
                $nav_path = '..'.DS.'assets'.DS.'js'.DS.'navbar.js';
            }
            $output .= file_get_contents($nav_path);
            $output .= '</script>';
            return $output;
        }
    }
?>