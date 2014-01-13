/*
 * 	Additional function for forms.html
 *	Written by ThemePixels	
 *	http://themepixels.com/
 *
 *	Copyright (c) 2012 ThemePixels (http://themepixels.com)
 *	
 *	Built for Katniss Premium Responsive Admin Template
 *  http://themeforest.net/category/site-templates/admin-templates
 */

jQuery(document).ready(function(){
	
	// Transform upload file
	jQuery('.uniform-file').uniform();
	
	// Dual Box Select
	var db = jQuery('#dualselect').find('.ds_arrow button');	//get arrows of dual select
	var sel1 = jQuery('#dualselect select:first-child');		//get first select element
	var sel2 = jQuery('#dualselect select:last-child');			//get second select element
	
	sel2.empty(); //empty it first from dom.
	
	db.click(function(){
		var t = (jQuery(this).hasClass('ds_prev'))? 0 : 1;	// 0 if arrow prev otherwise arrow next
		if(t) {
			sel1.find('option').each(function(){
				if(jQuery(this).is(':selected')) {
					jQuery(this).attr('selected',false);
					var op = sel2.find('option:first-child');
					sel2.append(jQuery(this));
				}
			});	
		} else {
			sel2.find('option').each(function(){
				if(jQuery(this).is(':selected')) {
					jQuery(this).attr('selected',false);
					sel1.append(jQuery(this));
				}
			});		
		}
		return false;
	});	
	
	
	// Select with Search
	if(jQuery(".chzn-select").length)
		jQuery(".chzn-select").chosen();
	
	
	
	// With Form Validation
	if(jQuery("#form1").length)
	{
		jQuery("#form1").validate({
			rules: {
				firstname: "required",
				lastname: "required",
				email: {
					required: true,
					email: true,
				},
				location: "required",
				selection: "required"
			},
			messages: {
				firstname: "Please enter your first name",
				lastname: "Please enter your last name",
				email: "Please enter a valid email address",
				location: "Please enter your location"
			},
			highlight: function(label) {
				jQuery(label).closest('.control-group').addClass('error');
		    },
		    success: function(label) {
		    	label
		    		.text('Ok!').addClass('valid')
		    		.closest('.control-group').addClass('success');
		    }
		});
	}
	
});


