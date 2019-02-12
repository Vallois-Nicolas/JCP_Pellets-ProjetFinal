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
        $('#deleteAccount').hide();
    });
    $('#cancelModifForm').click(function(){
        $('.modifyForm').hide();
        $('.infoUser').show();
        $('#cancelModifForm').hide();
        $('#showModifForm').show();
        $('#submitModifForm').hide();
        $('#deleteAccount').show();
    });
    $('#deleteAccount').click(function(){
        $('#deleteAccount').hide();
        $('#agreementDeleteAccount').show();
        $('#disagreeDeleteAccount').show();
        $('#agreementSentence').show();
        $('#showModifForm').hide();
    });
    $('#disagreeDeleteAccount').click(function(){
        $('#deleteAccount').show();
        $('#agreementDeleteAccount').hide();
        $('#disagreeDeleteAccount').hide();
        $('#agreementSentence').hide();
        $('#showModifForm').show();
    })
});
