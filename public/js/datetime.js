jQuery(document).ready(function($){
                
    window.livewire.components.registerHook('afterDomUpdate',  () => {

        $('.fechahora').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD hh:mm A',
            inline: true,
            sideBySide: true,
            keepOpen: true,
            debug:true
        }).on('dp.change', function (ev) {
            var fechastreaming = ev.date.format('YYYY-MM-DD hh:mm A');
            Livewire.emit('setfecha', fechastreaming);
        });
    });

});