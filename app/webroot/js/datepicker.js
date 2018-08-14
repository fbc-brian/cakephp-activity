$( function() {
    var start = new Date();
    var yearStart = start.getFullYear() - 70;
    var end = new Date();
    var yearEnd = end.getFullYear() - 18;
    $( "#datepicker" ).datepicker({
      yearRange: "1890:2000",
      defaultDate: "01-01-1992",
      dateFormat: "mm-dd-yy",
      changeMonth: true,
      changeYear: true,
    });

    $("#imgInp").change(function() {
      readURL(this);
    });

    $('.js-select').select2({placeholder: "Search for a recipient", allowClear: true});

    $('#MessageFromForm').submit(function(e){    
        e.preventDefault();
        var para = {}
        para['url']  = $(this).attr('action');
        para['post'] = $(this).serialize();
        var getAjax = para;
        $('#MessageFromForm').find('button[type=submit]').attr('disabled');
        autoCall(getAjax, function (data) {
          console.log(data);
          if(data.status){
            $('#MessageStatus').prepend("<div class='notification success closeable'>"+ data.msg +"</div>");
            $('#MessageFromForm').find('textarea').val('');

          }else{        
            $('#MessageStatus').prepend("<div class='notification error closeable'>"+ data.msg +"</div>");
          }
          $('.notification').fadeTo(2000, 500).slideUp(500, function(){
            $('.notification').slideUp(500);
            $('#MessageStatus').html('');
          });

        });
        $('#MessageFromForm').find('button[type=submit]').attr('disabled', false);
    });


    $.validate({
      lang: 'en'
    });

    $('#loadmore').click(function(e){    
        e.preventDefault();
        var para = {}        
        var newCurrentPage = parseInt($(this).data('current')) + 1;
        var totalPages = parseInt($('#tbody').data('total'));

        console.log(newCurrentPage + '<' + totalPages);
        para['url']  = $(this).attr('href') + ':' + newCurrentPage;

        if($(this).data('search') != false){
          para['post'] = $(this).data('search');
          autoCall(para, function (data) {
            console.log(data); 
            if(data.status){
              $('#tbody').append(data.msg);
            }
          });
        } else {

          getCall(para, function (data) {
            console.log(data); 
            if(data.status){
              $('#tbody').append(data.msg);
            }
          });
        }

        if(newCurrentPage < totalPages){
           $('#loadmore').data('current', newCurrentPage);
        }else{
          $('.paging.text-center').html('<p>No More Message to Load...</p>')
        }

        takeShort();
    });

    $('#search').submit(function(e){ 
        e.preventDefault();
        var para = {}
        para['url']  = $(this).attr('action');
        para['post'] = $(this).serialize();
        var tbody = $('#tbody');
        var loadmore = $('#loadmore');
        var getAjax = para;
        $('#MessageFromForm').find('button[type=submit]').attr('disabled');
        autoCall(getAjax, function (data) {
          console.log(data);
          if(data.status){
            tbody.html(data.msg);
            tbody.data('total', data.pages);
            loadmore.data('current', 1);
            loadmore.data('search', para['post']);
            loadmore.attr('href', '/messageboard/messages/search/page');
          }else{        
            $('.notify').prepend("<div class='notification error closeable'>"+ data.msg +"</div>");
          }
          $('.notification').fadeTo(2000, 500).slideUp(500, function(){
            $('.notification').slideUp(500);
            $('.notify').html('');
          });

        });
        console.log(tbody.data());
        $('#MessageFromForm').find('button[type=submit]').attr('disabled', false);

    });

    $('#tbody').on('click', '.delete_convo',function(e){  

        e.preventDefault();
        var para = {}  
        var parent = $(this).parent().parent();
        para['url']  = $(this).attr('href');
        var getAjax = para;
        getCall(getAjax, function (data) {
          if(data.status){
            $('.notify').prepend("<div class='notification success closeable'>"+ data.msg +"</div>");
            parent.remove();
          }else{        
            $('.notify').prepend("<div class='notification error closeable'>"+ data.msg +"</div>");
          }

        console.log(data);
        });

        $(".notification").fadeTo(2000, 500).slideUp(500, function(){
          $(".notification").slideUp(500);
           $('.notify').html('');
        });
    });

    $('#tbody').on('click', '.delete',function(e){  
        e.preventDefault();
        var para = {}  
        var parent = $(this).parent().parent();
        para['url']  = $(this).attr('href');
        autoCall(para, function (data) {
          if(data.status){ 
            parent.remove();
            alert(data.msg);
          }else{        
            alert(data.msg);
          }
        });
    });
    
    takeShort();

});

  function takeShort() {
    $('.take-short').moreLines({
        linecount: 2, 
        baseclass: 'b-description',
        basejsclass: 'js-description',
        classspecific: '_readmore',    
        buttontxtmore: "read more",               
        buttontxtless: "read less",
        animationspeed: 250 
    });
  }

 function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#profile').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}



function autoCall(parArray, callback) {
  $.ajax({
    async: false,
    url: parArray['url'],
    dataType: "json",
    type: "POST",
    data:parArray['post'],
    success: callback,
    error : function(jqXHR) {
      var msg = '';
      if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
      } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
      } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
      } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
      } else if (exception === 'timeout') {
        msg = 'Time out error.';
      } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
      } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
      }
      console.log(msg);
    }
  });
}

function getCall(parArray, callback) {
  $.ajax({
    async: false,
    url: parArray['url'],
    dataType: "json",
    type: "GET",
    success: callback,
    error : function(jqXHR) {
      console.log(jqXHR);
      var msg = '';
      if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
      } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
      } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
      } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
      } else if (exception === 'timeout') {
        msg = 'Time out error.';
      } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
      } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
      }
      console.log(msg);
    }
  });
}