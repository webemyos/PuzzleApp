/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        config.extraPlugins = 'tabbedimagebrowser,allowsave';
        
       // CKEDITOR.config.tabbedimages = new Array("http://localhost/webemyos/Webemyos3.0.1/Images/startup.png");
       // CKEDITOR.config.tabbedthumbimages = new Array("http://localhost/webemyos/Webemyos3.0.1/Images/startup.png");
 config.toolbar_Basic =
        [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-', 'Source', 'About']
        ];

};
