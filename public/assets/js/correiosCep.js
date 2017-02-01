function LocalizaCep(tipo){
    if(tipo==null){
        $("input[id=street]").attr({readonly: 'true'});
        $("input[id=neighborhood]").attr({readonly: 'true'});
        $("input[id=city]").attr({readonly: 'true'});
        $("input[id=uf]").attr({readonly: 'true'});
    }
    $("input[id=cep]").blur(function(){
        var cep = $(this).val().replace(/[^0-9]/, '');
        if(cep !== ""){
            var url = 'http://cep.correiocontrol.com.br/'+cep+'.json';
            $.getJSON(url, function(json){
                $("input[id=street]").val(json.logradouro);
                $("input[id=neighborhood]").val(json.bairro);
                $("input[id=city]").val(json.localidade);
                $("input[id=uf]").val(json.uf);
            }).fail(function(){
                $("input[id=street]").val("");
                $("input[id=neighborhood]").val("");
                $("input[id=city]").val("");
                $("input[id=uf]").val("");
            });
        }
    });
}