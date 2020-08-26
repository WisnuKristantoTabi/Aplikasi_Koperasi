$(document).ready(function () {
$('.namasearch').select2({
    placeholder: 'Cari Nama',
    ajax: {
      url: "{{url('/userauto')}}",
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.full_name,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });
 });
