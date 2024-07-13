$(document).ready(function(){
   
    var i = 1;
    var no =1;
    $("#add").click(function(){
      
     i++;
    no++;
        $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="instruction[]" placeholder="Instruction '+no+ '" class="form-control" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });
  
    $(document).on('click', '.btn_remove', function(){  
        var button_id = $(this).attr("id");     
        no--;
        $('#row'+button_id+'').remove();  
      });
      
  
  
    //   $("#submit").on('click',function(event){
    //   var formdata = $("#add_name").serialize();
    //     console.log(formdata);
        
    //     event.preventDefault()
        
    //     $.ajax({
    //       url   :"action.php",
    //       type  :"POST",
    //       data  :formdata,
    //       cache :false,
    //       success:function(result){
    //         alert(result);
    //         $("#add_name")[0].reset();
    //       }
    //     });
        
    //   });
    });