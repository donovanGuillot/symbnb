$('#add-image').click(function(){
    //Je récupère le numéro des futures champs que je vais créer
    const index = +$('#widgets-counter').val();
    //Je créer le prototype des entrées
    const tmpl = $('#annonce_images').data('prototype').replace(/__name__/g, index);

    //Injection du template dans la div
    $('#annonce_images').append(tmpl);

    $('#widgets-counter').val(index + 1)

    //Je gère le bouton supprimer
    handleDeleteButton();
});

/**
* Permet de supprimer une div Image
*/
function handleDeleteButton(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter(){
    const count = +$('#annonce_images div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButton();