//function successRegister(){
//    swal({
//        title: "Bienvenu chez nous !",
//        text: "Vous pouvez à présent vous connecter sans problème !",
//        icon: "success"
//    });
//}
$(function () {
    
  $('[data-toggle="popover"]').popover();
  
  $('#showModifForm').click(function(){
      $('.modifyForm').show();
      $('.infoUser').hide();
      $('#cancelModifForm').show();
      $('#showModifForm').hide();
      $('#submitModifForm').show();
  });
  $('#cancelModifForm').click(function(){
      $('.modifyForm').hide();
      $('.infoUser').show();
      $('#cancelModifForm').hide();
      $('#showModifForm').show();
      $('#submitModifForm').hide();
  });
  
});
