/**
 * This JavaScript file is here in case we need 
 * specific functionality for the settings page.
 */

jQuery(function () {
	MCEasyPublisherSettingsView.Init();	
});

if (!this.MCEasyPublisherSettingsView) {
	MCEasyPublisherSettingsView = {};
}

MCEasyPublisherSettingsView.Init = function () {
	
	if (jQuery('#EasyPublisherSettingsPage .message').length > 0) {
		setTimeout(function () {
			jQuery('#EasyPublisherSettingsPage .message').fadeOut(500);			
		}, 2000);
	}
	
};