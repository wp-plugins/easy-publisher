/**
 * TODO: Copyright information.
 */

if (!this.MCEasyPublisher) {
	MCEasyPublisher = {};
	MCEasyPublisher.settings = null;
}

jQuery(function () {

	jQuery('#title').keyup(function (e) {

		MCEasyPublisher.UpdateAdminBarPageTitle();
		
	});

	MCEasyPublisher.UpdateAdminBarPageTitle();
	
	if (MCEasyPublisher.settings != null) {
		
		if (MCEasyPublisher.settings.showAdminBarInFullscreen) {
			jQuery('#wpadminbar').addClass('mcep_show_admin_bar_in_fullscreen');
			jQuery('#fullscreen-topbar').addClass('mcep_show_admin_bar_in_fullscreen');
			jQuery('#wp-content-wrap').addClass('mcep_show_admin_bar_in_fullscreen');
		}
		
		if (MCEasyPublisher.settings.showPreviewButtonInFullscreenBar) {

			var $preview = jQuery('#post-preview');
			$preview.clone()
				.removeAttr('id').removeClass('preview').addClass('right')
				.text('Preview')
				.css('margin-left', '5px')
				.click(function(e) {
					$preview.click();
					e.preventDefault();
				})
				.insertBefore('#wp-fullscreen-save input.button-primary');
			
		}

		if (MCEasyPublisher.settings.showViewPostButtonInFullscreenBar) {
			
			var $viewPost = jQuery('#view-post-btn a');
			$viewPost.clone().removeClass('button button-small')
				.addClass('mcViewPostButton')
				.attr('target', 'newWindow')
				.appendTo('#wp-fullscreen-close');
		
		}
		
		if (MCEasyPublisher.settings.keepFullscreenBarVisible) {

			jQuery('#fullscreen-topbar').addClass('keep_visible');

		}
		
		if (MCEasyPublisher.settings.viewPostInNewTab) {
			jQuery('#view-post-btn a').attr('target', 'newWindow');
			jQuery('#wp-admin-bar-view a').attr('target', 'newWindow');
		}
	}
	
});

MCEasyPublisher.UpdateAdminBarPageTitle = function () {

	var $titleAdminBarElem = jQuery('#wp-admin-bar-MCEPostTitle div');
	var $titleTextboxElem = jQuery('#title');
	
	if ($titleAdminBarElem.length > 0  && 
			$titleTextboxElem.length > 0) {
		var titleStr = $titleTextboxElem.val();
		if (titleStr.length > 35) {
			titleStr = titleStr.substr(0, 35) + '...';
		}
		$titleAdminBarElem.text('Title: ' + titleStr);
	}
	
};

MCEasyPublisher.UpdatePost = function (e) {
	
	jQuery('#publish').click();
	
};
