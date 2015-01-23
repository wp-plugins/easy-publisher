/*
 This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
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
