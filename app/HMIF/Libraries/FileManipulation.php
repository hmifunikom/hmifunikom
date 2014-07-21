<?php namespace HMIF\Libraries;

use Input;
use File;

class FileManipulation {

    private $upload_field;

    private $file_object;
    private $filename;
    private $suffix;

    private $file_path;

    private $_uploaded = false;

    public function __construct($field, $filename, $safe = TRUE)
    {
        if($safe)
        {
            $this->file_path = storage_path().'/files';
        }
        else
        {
            $this->file_path = public_path().'/media/datas';   
        }


        if (Input::hasFile($field))
        {
            $this->filename = $filename;
            $this->suffix = '_'.str_random(3);

            $this->file_object = Input::file($field);
            $this->file_object->move($this->file_path, $this->getFileName());

            $this->_uploaded = true;
        }
    }

    public function isUploaded()
    {
        return $this->_uploaded;
    }

    public function getFileName()
    {
        return $this->filename.$this->suffix.'.'.$this->file_object->getClientOriginalExtension();
    }

    private function _destination()
    {
        return $this->file_path.'/'.$this->filename.$this->suffix.'.'.$this->file_object->getClientOriginalExtension();
    }

    public function __destruct()
    {
        
    }
}