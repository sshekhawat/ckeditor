<?php

namespace webvimark\extensions\ckeditor;

use yii\web\AssetBundle;

class CKEditorAsset extends AssetBundle
{
	public function init()
	{
		$this->sourcePath = __DIR__ . '/assets';
		$this->js = ['ckeditor/ckeditor.js'];

		parent::init();
	}
}