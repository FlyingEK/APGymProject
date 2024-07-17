


    $(document).ready(function(){
   
      var i = 1;
      var no =1;
      $("#addGoal").click(function(){
        i++;
        no++;
          $('#dynamic_field_goal').append('<tr id="row'+i+'"> <td ><div class="custom-select"><select class="form-select p-2" name="equipment[]" id="equipmentType" aria-label="Equipment Type"><option selected>Choose...</option><option value="1">One</option><option value="2">Two</option><option value="3">Three</option></select></div></td><td style="width:15%;"><input type="number" name="goalValue[]" placeholder="Duration/Weight" class="form-control" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
          initializeCustomSelect();
        });
    
      $(document).on('click', '.btn_remove', function(){  
          var button_id = $(this).attr("id");     
          no--;
          $('#row'+button_id+'').remove();  
        });
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
