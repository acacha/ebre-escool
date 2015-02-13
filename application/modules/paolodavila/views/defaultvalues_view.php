<script type="text/javascript" id="defaultvalues_view_script">
	
	/*
var ei_noLoadfnOpenEditForm = function(this_element){

	var href_url = this_element.attr("href");
	var dialog_height = $(window).height() - 80;

	//Close all
	$(".ui-dialog-content").dialog("close");

	$.ajax({
		url: href_url,
		data: {
			is_ajax: 'true'
		},
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			this_element.closest('.flexigrid').addClass('loading-opacity');
		},
		complete: function(){
			this_element.closest('.flexigrid').removeClass('loading-opacity');
		},
		success: function (data) {
			if (typeof CKEDITOR !== 'undefined' && typeof CKEDITOR.instances !== 'undefined') {
					$.each(CKEDITOR.instances,function(index){
						delete CKEDITOR.instances[index];
					});
			}
			
			$("<div/>").html(data.output).dialog({
				width: 910,
				modal: true,
				height: dialog_height,
				close: function(){
					$(this).remove();
				},
				open: function(){
					var this_dialog = $(this);

					$('#cancel-button').click(function(){
						this_dialog.dialog("close");
					});

				}
			});
		}
	});
};
*/

var set_form_default_values = function(){
	//MARKED FOR DELETION translation
	'<?php echo $field_prefix;?>'
	if (document.getElementById('field-<?php echo $table_name?>-<?php echo $field_prefix;?>markedForDeletion') != null) {
		var mfd=document.getElementById("field-<?php echo $table_name?>-<?php echo $field_prefix;?>markedForDeletion");
		//TRANSLATE MARKED FOR DELETION:

		mfd.options[1].text='<?php echo $no_translated ?>';
		mfd.options[2].text='<?php echo $yes_translated ?>';
		$('#field-<?php echo $table_name?>-<?php echo $field_prefix;?>markedForDeletion').trigger('liszt:updated');
	}
	
	//DISABLE markedForDeletionDate if markedForDeletion is no
	var $markedForDeletion = $('#field-<?php echo $table_name?>-<?php echo $field_prefix;?>markedForDeletion');
	var $markedForDeletionDate = $('#field-<?php echo $table_name?>-<?php echo $field_prefix;?>markedForDeletionDate');
	$markedForDeletion.change(function () {
		if ($markedForDeletion.val() == 'y') {
			$markedForDeletionDate.removeAttr('disabled'); 
		} else {
			$markedForDeletionDate.attr('disabled', 'disabled').val('');
		}
	}).trigger('change'); // added trigger to calculate initial state
	
	/************************
	* USER PREFERENCES FORM *
	*************************/
	
	//LANGUAGE translations
	if (document.getElementById('field-<?php echo $table_name?>-language') != null) {
		var language = document.getElementById('field-<?php echo $table_name?>-language');
		//TRANSLATE LANGUAGE:
		language.options[1].text='<?php echo $catalan_translated ?>';
		language.options[2].text='<?php echo $spanish_translated ?>';
		language.options[3].text='<?php echo $english_translated ?>';
		$('#field-<?php echo $table_name?>-language').trigger('liszt:updated');
	}
	
	//DialogForms translations
	if (document.getElementById('field-<?php echo $table_name?>-dialogforms') != null) {
		var dialogforms = document.getElementById('field-<?php echo $table_name?>-dialogforms');
		//TRANSLATE LANGUAGE:
		dialogforms.options[1].text='<?php echo $no_translated ?>';
		dialogforms.options[2].text='<?php echo $yes_translated ?>';
		$('#field-<?php echo $table_name?>-dialogforms').trigger('liszt:updated');
	}
	
	/****************************
	* END USER PREFERENCES FORM *
	*****************************/

/*******************************************
* END SET DEFAULT VALUES FOR CHOSEN FIELDS *
********************************************/	 

}

//MAIN JAVASCRIPT CODE
var pageInitialized = false;


$(document).ready(function(){
 
 //AVOID DOCUMENT READY TO EXECUTE TWO TIMES
 if (pageInitialized) return;
 pageInitialized = true;
 
 /***************************************
 * OUTSIDE FORM INITIALIZATION
 ****************************************/
 
 /** READONLY IMPLEMENTATION *********/
 //CHECK IF WE SET READ ONLY URL HASH (#readonly)
 if(window.location.hash.indexOf('readonly') != -1){
   //disable all input html elements:
   $('#main-table-box').find('input, textarea, button, select').attr('disabled','disabled');
   //HIDE BUTTONS
   $('.pDiv').hide();
 }
 /** END READONLY IMPLEMENTATION *********/
 
 /***************************************
 * END OUTSIDE FORM INITIALIZATION
 ****************************************/
 
 set_form_default_values();
 
});

</script>
