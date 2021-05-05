<?php

namespace controllers;
use core\Controller;
use models\Paste;

class PreviewController extends Controller {
    public function handlePreview($record) {
        return $this->render('preview', ['record' => $record]);   
    }
}