$('#edit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id')
  var nomorperkiraan =  button.data('nomorperkiraan')
  var pti =  button.data('pti')
  var npd =  button.data('npd')
   var title =  button.data('title')

  var modal = $(this)
  modal.find('.modal-title').text(title)
  modal.find('.modal-body #id').val(id)
  modal.find('.modal-body #nomorperkiraan').val(nomorperkiraan)
  modal.find('.modal-body #nama').val(npd)
  modal.find('.modal-body #pti').val(pti)
})
