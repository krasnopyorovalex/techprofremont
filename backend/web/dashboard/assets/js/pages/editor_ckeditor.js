/* ------------------------------------------------------------------------------
*
*  # CKEditor editor
*
*  Specific JS code additions for editor_ckeditor.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

jQuery(function() {

    CKEDITOR.replace('editor-min', {
        height: '220px',
        toolbarGroups: [
            { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
            { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'others' },
            '/',
            { name: 'paragraph',   groups: [ 'list', 'align'] },
            { name: 'styles' }
        ]
    });
    CKEDITOR.replace('editor-min-05', {
        height: '220px',
        toolbarGroups: [
            { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
            { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'others' },
            '/',
            { name: 'paragraph',   groups: [ 'list', 'align'] },
            { name: 'styles' }
        ]
    });
    CKEDITOR.replace('editor-min-02', {
        height: '220px',
        toolbarGroups: [
            { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
            { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'others' },
            '/',
            { name: 'paragraph',   groups: [ 'list', 'align'] },
            { name: 'styles' }
        ]
    });

});
