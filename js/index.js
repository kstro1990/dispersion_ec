function sendDisper(){
    var corriente = $('select[id=corriente]').val();
    var valorAirline = $("#valorAirline").val();
    var valorMerchant = $("#valorMerchant").val();
    var login = $("#login").val();
    var trankey = $("#trankey").val();
    var total = $("#total").val();
    var airline = $('select[id=airline]').val();
    
    // alert('holamundo - '+ total);
    $(".section").append("<div class='text-center'><div class='spinner-border text-primary' role='status'><span class='sr-only'>Loading...</span></div></div>");
    $.ajax({
      method: "POST",
      url: "Seting.php",
      data: {
        total : total,
        login : login,
        trankey : trankey,
        valorAirline : valorAirline,
        valorMerchant : valorMerchant,
        airline : airline
      },
      success: function(result) {
        console.log(result);
        var r=$('<input/>').attr({type: "button",  id: "field", value: 'new'});
        var t=$('<a/>').attr({href: result,  id: "222222", target: '_blank', value:'holamundo', class: 'btn btn-primary', accessKey:'estoy aqui'}).val('ksajd');
        $( ".section" ).empty();
        $(".section").append("<p class='card-text'>" + result + "</p>");
        $(".section").append(t);
        $("html, body").animate({
        scrollTop: 0
        }, 500);
      },
        error:function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function sumaTotal(){
    var valorAirline = $("#valorAirline").val();
    valorAirline = parseInt(valorAirline);
    var valorMerchant = $("#valorMerchant").val();
    valorMerchant = parseInt(valorMerchant);
    var valor = (valorAirline + valorMerchant);
    $("#total").val(valor);
}

function validate(input){
    if(/[^0-9,]/.test(input.value))input.value = input.value.replace(/[^0-9,]/g,'');
}
