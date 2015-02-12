/*** Admin script file
* @package ...
**/

window.addEvent("domready",function(){

  // Toggle custom_module_id field
	var custom_module_id = [
	  document.id('jform_params_custom_module_id'), 
	];
	
	custom_module_id.each(function(el,j){
		if(el) {
			el.getParent().setStyle('display','none');
		}
	});
	
	if(document.id('jform_params_auto_module_id').value === '0') {
		document.id('jform_params_custom_module_id').getParent().setStyle('display','');
	}
	
	document.id('jform_params_auto_module_id').addEvent("change", function(){
		custom_module_id.each(function(el,j){
			el.getParent().setStyle('display','none');
		});
		if(document.id('jform_params_auto_module_id').value === '0') {
			document.id('jform_params_custom_module_id').getParent().setStyle('display','');
		}
	});
	
	document.id('jform_params_auto_module_id').addEvent("blur", function(){
		custom_module_id.each(function(el,j){
			el.getParent().setStyle('display','none');
		});	
		if(document.id('jform_params_auto_module_id').value === '0') {
			document.id('jform_params_custom_module_id').getParent().setStyle('display','');
		}
	});
	
	// Toggle data_source fields
	var data_sources = [
	  document.id('jform_params_catfilter'), 
	  document.id('jformparamscategory_id'), 
	  document.id('jform_params_getChildren'), 
		document.id('jform[params][add_k2_items]_name').getParent(), 
	  document.id('itemsList'),
		document.id('jform_params_k2_tags'),
		document.id('jform_params_exclude_k2_items'),
		document.id('jform_params_FeaturedItems'),
		document.id('jform_params_popularityRange'),
		document.id('jform_params_videosOnly'),
		document.id('jform_params_items_order')
	];
	
	data_sources.each(function(el,j){
		if(el) {
			el.getParent().setStyle('display','none');
		}
	})

	if(document.id('jform_params_data_source').value === 'k2_categories') {
	  document.id('jform_params_catfilter').getParent().setStyle('display','');
		document.id('jformparamscategory_id').getParent().setStyle('display','');
		document.id('jform_params_getChildren').getParent().setStyle('display','');
		document.id('jform_params_exclude_k2_items').getParent().setStyle('display','');
		document.id('jform_params_FeaturedItems').getParent().setStyle('display','');
		document.id('jform_params_popularityRange').getParent().setStyle('display','');
		document.id('jform_params_videosOnly').getParent().setStyle('display','');
		document.id('jform_params_items_order').getParent().setStyle('display','');
	}
	
	if(document.id('jform_params_data_source').value === 'k2_articles') {
		document.id('jform[params][add_k2_items]_name').getParent().getParent().setStyle('display','');
		document.id('itemsList').getParent().setStyle('display','');
		
	}
	
	if(document.id('jform_params_data_source').value === 'all_k2_articles') {
		document.id('jform_params_exclude_k2_items').getParent().setStyle('display','');
		document.id('jform_params_FeaturedItems').getParent().setStyle('display','');
		document.id('jform_params_popularityRange').getParent().setStyle('display','');
		document.id('jform_params_videosOnly').getParent().setStyle('display','');
		document.id('jform_params_items_order').getParent().setStyle('display','');
	}
	
	if(document.id('jform_params_data_source').value === 'k2_tags') {
		document.id('jform_params_k2_tags').getParent().setStyle('display','');
		document.id('jform_params_exclude_k2_items').getParent().setStyle('display','');
		document.id('jform_params_FeaturedItems').getParent().setStyle('display','');
		document.id('jform_params_popularityRange').getParent().setStyle('display','');
		document.id('jform_params_videosOnly').getParent().setStyle('display','');
		document.id('jform_params_items_order').getParent().setStyle('display','');
	}
	
	document.id('jform_params_data_source').addEvent("change", function(){
		data_sources.each(function(el,j){
			el.getParent().setStyle('display','none');
		});

		if(document.id('jform_params_data_source').value === 'k2_categories') {
		  document.id('jform_params_catfilter').getParent().setStyle('display','');
			document.id('jformparamscategory_id').getParent().setStyle('display','');
		  document.id('jform_params_getChildren').getParent().setStyle('display','');
		  document.id('jform_params_exclude_k2_items').getParent().setStyle('display','');
			document.id('jform_params_FeaturedItems').getParent().setStyle('display','');
		  document.id('jform_params_popularityRange').getParent().setStyle('display','');
		  document.id('jform_params_videosOnly').getParent().setStyle('display','');
			document.id('jform_params_items_order').getParent().setStyle('display','');
	  }
	
	  if(document.id('jform_params_data_source').value === 'k2_articles') {
		  document.id('jform[params][add_k2_items]_name').getParent().getParent().setStyle('display','');
		  document.id('itemsList').getParent().setStyle('display','');
	  }
	
	  if(document.id('jform_params_data_source').value === 'all_k2_articles') {
		  document.id('jform_params_exclude_k2_items').getParent().setStyle('display','');
			document.id('jform_params_FeaturedItems').getParent().setStyle('display','');
		  document.id('jform_params_popularityRange').getParent().setStyle('display','');
		  document.id('jform_params_videosOnly').getParent().setStyle('display','');
			document.id('jform_params_items_order').getParent().setStyle('display','');
	  }
	
	  if(document.id('jform_params_data_source').value === 'k2_tags') {
		  document.id('jform_params_k2_tags').getParent().setStyle('display','');
		  document.id('jform_params_exclude_k2_items').getParent().setStyle('display','');
			document.id('jform_params_FeaturedItems').getParent().setStyle('display','');
		  document.id('jform_params_popularityRange').getParent().setStyle('display','');
		  document.id('jform_params_videosOnly').getParent().setStyle('display','');
			document.id('jform_params_items_order').getParent().setStyle('display','');
	  }
	
	});
	
	document.id('jform_params_data_source').addEvent("blur", function(){
		data_sources.each(function(el,j){
			el.getParent().setStyle('display','none');
		});
		
		if(document.id('jform_params_data_source').value === 'k2_categories') {
		  document.id('jform_params_catfilter').getParent().setStyle('display','');
			document.id('jformparamscategory_id').getParent().setStyle('display','');
		  document.id('jform_params_getChildren').getParent().setStyle('display','');
		  document.id('jform_params_exclude_k2_items').getParent().setStyle('display','');
			document.id('jform_params_FeaturedItems').getParent().setStyle('display','');
		  document.id('jform_params_popularityRange').getParent().setStyle('display','');
		  document.id('jform_params_videosOnly').getParent().setStyle('display','');
			document.id('jform_params_items_order').getParent().setStyle('display','');
	  }
	
	  if(document.id('jform_params_data_source').value === 'k2_articles') {
		  document.id('jform[params][add_k2_items]_name').getParent().getParent().setStyle('display','');
		  document.id('itemsList').getParent().setStyle('display','');
	  }
	
	  if(document.id('jform_params_data_source').value === 'all_k2_articles') {
		  document.id('jform_params_exclude_k2_items').getParent().setStyle('display','');
			document.id('jform_params_FeaturedItems').getParent().setStyle('display','');
		  document.id('jform_params_popularityRange').getParent().setStyle('display','');
		  document.id('jform_params_videosOnly').getParent().setStyle('display','');
			document.id('jform_params_items_order').getParent().setStyle('display','');
	  }
	
	  if(document.id('jform_params_data_source').value === 'k2_tags') {
		  document.id('jform_params_k2_tags').getParent().setStyle('display','');
		  document.id('jform_params_exclude_k2_items').getParent().setStyle('display','');
			document.id('jform_params_FeaturedItems').getParent().setStyle('display','');
		  document.id('jform_params_popularityRange').getParent().setStyle('display','');
		  document.id('jform_params_videosOnly').getParent().setStyle('display','');
			document.id('jform_params_items_order').getParent().setStyle('display','');
	  }
		
	});
	
});
