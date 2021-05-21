$(function() {
  $('#AddNewPage').submit(function(event) {
       event.preventDefault();
       var page_title = $('#page_title').val();
    if(page_title =='') {
	   alert('Please enter Page Title');
	   $('#page_title').focus(); //The focus function will move the cursor to "fullname" field
    }else{
        $(".loader").show();
        var formEl = $(this);
        var submitButton = $('button[type=submit]', formEl);
        $.ajax({
          type: 'POST',
           url: formEl.prop('action'),
           accept: {
            javascript: 'application/javascript'
           },
          data: formEl.serialize(),
           beforeSend: function() {
            submitButton.prop('disabled', 'disabled');
           }
          }).done(function(data){
            var obj = jQuery.parseJSON(data);
            //alert(obj.id);
            setTimeout(function() 
            {
               var url = base_url+'admin/pages/edit/'+obj.lang+'/'+obj.id;
               $(".loader").hide();
               window.location.href = url;
             
            }, 2000);
          
        });
    }
  });

  // bind 'myForm' and provide a simple callback function
  $("#page_title").keyup(function(event) {
      var stt = $(this).val();
          str = stt.replace(/\s+/g, '-').toLowerCase();
          str = str.replace(/\W+(?!$)/g, '-').toLowerCase();
          str = str.replace(/\W$/, '').toLowerCase();
          $("#page_slug").val(str);
          $("#page_slug_lebel").text(str);  
   });

});


