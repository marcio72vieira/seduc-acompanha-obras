// Uso do SweetAlert2
// Receber o seletor apagar e percorrer a lista de registros
document.querySelectorAll('.btnDelete').forEach( function(button){

    // Aguardar o clique do usuário no botão apagar
    button.addEventListener('click', function(event){
        event.preventDefault();

        // Receber define a Entidade a ser deletda, o atributo que possui o id do registro e seu respectivo valor a ser excluído
        var deleteEntidade = this.getAttribute('data-delete-entidade');
        var deleteId = this.getAttribute('data-delete-id');
        var valueRecord = this.getAttribute('data-value-record');


        // SweetAlert
        Swal.fire({
            title: 'Excluir ' + deleteEntidade + '\n' + valueRecord + ' ?',
            text: 'Você não poderá reverter esta ação!',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#0d6efd',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: "#dc3545",
            confirmButtonText: "Excluir!"
        }).then((result) => {
            // Carregar a página responsável em excluir se o usuário confirmar a exclusão
            if (result.isConfirmed) {

                document.getElementById(`formDelete${deleteId}`).submit();
            }
        });
    });
})

// Instanciação do JQuery. Assim que a página é carregada os scripts abaixo, serão carregados
$(document).ready(function() {
    /************************/
    // Uso do Select2
    // Acrescentar a classe ".select2" em todos os selects que houver a necessidade de utilizar o select2
    /*************************/
    $('.select2').select2({
        theme: 'bootstrap-5',
    });



    /***********************************/
    // Uso do jquerymask
    /***********************************/
    $('.phone').mask('(00) 00000-0000');
    $('#telefone').mask('(00) 00000-0000');
    //$('#cpf').mask('000.000.000-00');
    //$('#cep').mask('00000-000');
    $('.cpf').mask('000.000.000-00');
    $('.cep').mask('00000-000');
    $('#cnpj').mask('00.000.000/0000-00', {reverse: true});

    // MASK
    var cellMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    cellOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(cellMaskBehavior.apply({}, arguments), options);
        }
    };

    $('.mask-cell').mask(cellMaskBehavior, cellOptions);
    $('.mask-phone').mask('(00) 0000-0000');
    $(".mask-date").mask('00/00/0000');
    $(".mask-datetime").mask('00/00/0000 00:00');
    $(".mask-month").mask('00/0000', {reverse: true});
    $(".mask-doc").mask('000.000.000-00', {reverse: true});
    $(".mask-cnpj").mask('00.000.000/0000-00', {reverse: true});
    $(".mask-zipcode").mask('00000-000', {reverse: true});
    $(".mask-money").mask('R$ 000.000.000.000.000,00', {reverse: true, placeholder: "R$ 0,00"});


    /**************** */
    // USO DATATABLE
    /**************** */
    $('#datatablesTeste').DataTable({});

});


