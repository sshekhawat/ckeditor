CKEditor for Yii 2
=====
Text editor

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist webvimark/ckeditor "*"
```

or add

```
"webvimark/ckeditor": "*"
```

to the require section of your `composer.json` file.

Usage
-----

```php
\webvimark\extensions\ckeditor\CKEditor::widget();
```

Possible settings (with default values)
---------------------------------------

'type' => CKEditor::TYPE_STANDARD,

'height'=>'200px',

'language'=>Yii::$app->language,