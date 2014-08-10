<?php
namespace webvimark\extensions\ckeditor;

use yii\base\Widget;
use Yii;

class CKEditor extends Widget
{
	const TYPE_FULL = 'full';
	const TYPE_STANDARD = 'standard';
	const TYPE_SIMPLE = 'simple';

	/**
	 * "full", "standard", "simple"
	 *
	 * @var string
	 */
	public $type = self::TYPE_STANDARD;

	/**
	 * @var string
	 */
	public $height = '200px';

	/**
	 * @var string
	 */
	public $language;

	public $pluginOptions = [];

	/**
	 * @return string|void
	 */
	public function run()
	{
		if ( !$this->language )
			$this->language = Yii::$app->language;

		$bundle = CKEditorAsset::register($this->view);

		$dir = $bundle->baseUrl;

		$js = <<<JS
			CKEDITOR.replaceAll(function(textarea, config) {
				config.height = '{$this->height}';
				config.language = '{$this->language}';
				config.filebrowserBrowseUrl = '$dir/kcfinder/browse.php?type=files';
				config.filebrowserImageBrowseUrl = '$dir/kcfinder/browse.php?type=images';
				config.filebrowserFlashBrowseUrl = '$dir/kcfinder/browse.php?type=flash';
				config.filebrowserUploadUrl = '$dir/kcfinder/upload.php?type=files';
				config.filebrowserImageUploadUrl = '$dir/kcfinder/upload.php?type=images';
				config.filebrowserFlashUploadUrl = '$dir/kcfinder/upload.php?type=flash';
				config.allowedContent = true;
			});
JS;

		$this->view->registerJs($js);

		$script = '';

		if ( $this->type == 'simple' )
		{
			$script = "
				CKEDITOR.config.toolbar = [
					['Maximize','Format','Bold','Italic','Underline','StrikeThrough','-','NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Link', 'Unlink']
				] ;
			";
		}
		elseif  ( $this->type == 'standard' )
		{
			$script = "
				CKEDITOR.config.toolbar = [
					['Maximize','Format'],
					['Bold','Italic','Underline','StrikeThrough','-','Print'],
					['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
					['Image','Table','-','Link', 'Unlink']
				] ;
			";
		}

		if ( $script !== '' )
		{
			$this->view->registerJs($script);
		}
	}
} 
