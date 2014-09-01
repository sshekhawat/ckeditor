<?php
namespace webvimark\extensions\ckeditor;

use yii\base\Widget;
use Yii;

class CKEditor extends Widget
{
	const TYPE_FULL = 'full';
	const TYPE_STANDARD = 'standard';
	const TYPE_SIMPLE = 'simple';
	const TYPE_INLINE = 'inline';

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

	/**
	 * @var array
	 */
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

		if ( $this->type != CKEditor::TYPE_INLINE)
		{
			$js = <<<JS
				CKEDITOR.replaceAll(function(textarea, config) {
					config.height = '{$this->height}';

				});
JS;

			$this->view->registerJs($js);
		}


		$script = "
			CKEDITOR.config.language = '{$this->language}';
			CKEDITOR.config.filebrowserBrowseUrl = '$dir/kcfinder/browse.php?type=files';
			CKEDITOR.config.filebrowserImageBrowseUrl = '$dir/kcfinder/browse.php?type=images';
			CKEDITOR.config.filebrowserFlashBrowseUrl = '$dir/kcfinder/browse.php?type=flash';
			CKEDITOR.config.filebrowserUploadUrl = '$dir/kcfinder/upload.php?type=files';
			CKEDITOR.config.filebrowserImageUploadUrl = '$dir/kcfinder/upload.php?type=images';
			CKEDITOR.config.filebrowserFlashUploadUrl = '$dir/kcfinder/upload.php?type=flash';
			CKEDITOR.config.allowedContent = true;
		";

		if ( $this->type == CKEditor::TYPE_SIMPLE )
		{
			$script .= "
				CKEDITOR.config.toolbar = [
					['Maximize','Format','Bold','Italic','Underline','StrikeThrough','-','NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Link', 'Unlink']
				] ;
			";
		}
		elseif  ( $this->type == CKEditor::TYPE_STANDARD )
		{
			$script .= "
				CKEDITOR.config.toolbar = [
					['Maximize','Format'],
					['Bold','Italic','Underline','StrikeThrough','-','Print'],
					['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
					['Image','Table','-','Link', 'Unlink']
				] ;
			";
		}
		elseif  ( $this->type == CKEditor::TYPE_INLINE )
		{
			$script .= "
				CKEDITOR.config.extraPlugins = 'inlinesave';

				CKEDITOR.config.toolbar = [
					['Inlinesave','Format'],
					['Bold','Italic','Underline','StrikeThrough','-','Print'],
					['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
					['Image','Table','-','Link', 'Unlink']
				] ;
			";
		}

		$this->view->registerJs($script);
	}
} 
