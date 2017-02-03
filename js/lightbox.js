$('a.lightbox-image').click(function(event) {

    var imageLink = $(this).attr('href');
    
    var lightboxModal = $('<div class="lightbox-modal modal fade" tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"><div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><img src="'+imageLink+'"></div></div></div></div>');
    
    $('body').append(lightboxModal);
    
    $('.lightbox-modal').modal('show');
  
  	$('.lightbox-modal').on('hidden.bs.modal', function(event){
        $('.lightbox-modal').modal('hide');
    	$('.lightbox-modal').remove();
	});
    event.preventDefault();
});