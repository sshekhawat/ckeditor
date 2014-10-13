CKEDITOR.plugins.add( 'inlinesave',
{
	init: function( editor )
	{
		editor.addCommand( 'inlinesave',
			{
				exec : function( editor )
				{

					addData();

					function addData() {
						var data = editor.getData();
						var dataID = editor.container.getId();

						jQuery.ajax({

							type: "POST",

							//Specify the name of the file you wish to use to handle the data on your web page with this code:
							//<script>var inline_save_url="yourfile.php";</script>
							//(Replace "yourfile.php" with the relevant file you wish to use)
							//Data can be retrieved from the variable $_POST['editabledata']
							//The ID of the editor that the data came from can be retrieved from the variable $_POST['editorID']

							url: inline_save_url,

							data: { editabledata: data, editorID: dataID }

						})

						.done(function (data, textStatus, jqXHR) {
							window.location.reload();
						})

						.fail(function (jqXHR, textStatus, errorThrown) {

							alert("Error saving content. [" + jqXHR.responseText + "]");

						});

					}

				}
			});
		editor.addCommand( 'inlinecancel',
			{
				exec : function( editor )
				{
					if (confirm('Cancel without saving ?')) {
						window.location.reload();
					}
				}
			});
		editor.ui.addButton( 'Inlinesave',
		{
			label: 'Save',
			command: 'inlinesave',
			icon: this.path + 'images/inlinecancel.png'
		} );
		editor.ui.addButton( 'Inlinecancel',
		{
			label: 'Cancel',
			command: 'inlinecancel',
			icon: this.path + 'images/inlinecancel.png'
		} );
	}
} );