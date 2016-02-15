


//#schedule_item_asset

 $( document ).ready(function() {
     
     
     
     
     
     
     
     
  });




$( "#schedule_item_asset" ).change(function() {
    //console.log(this.value);
    
    if (this.value == '')
        {
            $( "#previewimage" ).html('')
        }
    
    $.get( "/asset/" + this.value + "/thumb", function( data ) {
        //alert( "Data Loaded: " + data );
        
        $( "#previewimage" ).html("<img src='" + data + "' />")
    });
    
});