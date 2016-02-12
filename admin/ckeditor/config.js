/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

	config.language = 'ko';          // 언어설정
	config.height = '560px';          // CKEditor 높이
	// config.width = '600px';           // CKEditor 넓이
	config.enterMode = CKEDITOR.ENTER_BR;            // Enter 입력시 <br/> 태그 변경
    config.shiftEnterMode = CKEDITOR.ENTER_P;        // Enter 입력시 <p> 태그 변경
    // config.startupFocus = true;                                  // 시작시 포커스 설정
    // config.font_defaultLabel = 'Gulim';                        // 기본 글씨 폰트
    // config.font_names = 'Gulim/Gulim;Dotum/Dotum;Batang/Batang;Gungsuh/Gungsuh;';    // 사용가능한 기타 폰트 설정
    config.fontSize_defaultLabel = '12px';                   // 기본 글씨 폰트 사이즈
	config.filebrowserUploadUrl = '/upload/upload.php';
};
