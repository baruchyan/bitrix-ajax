$(document).ready(function(){

    $.post('ajax.php',
        {
            controller: ['app', 'ajax', 'catalog', 'params'],
            action: 'set_params',
            params: params,
        },
        function(data) {

            console.log(data);

            if(data.status){
                // your actions
                console.log(data.fields.count);
            }

        }, 'json');

});