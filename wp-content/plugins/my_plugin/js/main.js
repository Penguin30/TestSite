$('#add_task_form').on('submit',function(e){
	var title=$(this).find('input[name=task_title]').val();
	var freelancer=$(this).find('select[name=freelancer]').val();
	if(title!=''){
		$.ajax({
          type:'POST',
          url:spyr_params.ajaxurl,
          data:{action:'add_task',title:title,freelancer:freelancer},
          success:function(msg){
          	console.log(msg);
          	alert('Success!!!!');
          	location.reload();
          }
      });
	}else{
		e.preventDefault();
	}
});
$('#show_quanity').on('change',function(){
  $('.panel-body').find('tbody').empty();
  var quan=$(this).val();
  $.ajax({
    datatype:'json',
    type:'POST',
    url:spyr_params.ajaxurl,
    data:{action:'quan',show_quanity:quan},
    success:function(msg){
      $('.panel-body').find('tbody').append(msg);            
    }
  });
});

$('button#name').on('click', function() {
  $(this).hasClass('desc') || $(this).hasClass('asc') ? 
  $(this).toggleClass('asc desc') : $(this).addClass('desc');
  var title=$(this).data('title');
  var num=$('#show_quanity').val();
  var order=$(this).attr('class');
  $('.panel-body').find('tbody').empty();
  $.ajax({
    type:'POST',
    url:spyr_params.ajaxurl,
    data:{action:'sort',title:title,num:num,order:order},
    success:function(msg){
      $('.panel-body').find('tbody').append(msg); 
    }
  });  
});
$('#serch_form').on('input',function(){
  var text=$(this).val();
  $('.panel-body').find('tbody').empty();
  var num=$('#show_quanity').val();
  $.ajax({
    type:'POST',
    url:spyr_params.ajaxurl,
    data:{action:'search',text:text,num:num},
    success:function(msg){
      $('.panel-body').find('tbody').append(msg); 
    }
  });  
});