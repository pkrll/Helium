/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	CKEDITOR.config.filebrowserImageBrowseUrl = "/admin/gallery/";
	CKEDITOR.config.filebrowserImageUploadUrl = "/upload/imagess/";
	CKEDITOR.config.filebrowserImageWindowWidth = '815';
	CKEDITOR.config.filebrowserImageWindowHeight = '680';
	CKEDITOR.config.skin = 'moono';
	// CKEDITOR.config.simpleImageBrowserListType = "thumbnails";
};
