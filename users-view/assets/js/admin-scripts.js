jQuery(document).ready(function($){
    console.log('aa');
    $( "#usersFileImport" ).change(function() {
        if ( $(this).val() != 0 ){
            $("#importUsers").prop("disabled", false)
        }
    });
});
