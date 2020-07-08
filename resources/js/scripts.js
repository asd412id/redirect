var language = {
  "decimal":        "",
  "emptyTable":     "Data tidak tersedia",
  "info":           "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
  "infoEmpty":      "Menampilkan 0 sampai 0 dari 0 data",
  "infoFiltered":   "(Difilter dari _MAX_ total data)",
  "infoPostFix":    "",
  "thousands":      ",",
  "lengthMenu":     "Menampilkan _MENU_ data",
  "loadingRecords": "Memuat...",
  "processing":     "Memproses...",
  "search":         "Cari:",
  "zeroRecords":    "Pencarian tidak ditemukan",
  "paginate": {
    "first":      "Pertama",
    "last":       "Terakhir",
    "next":       "Selanjutnya",
    "previous":   "Sebelumnya"
  }
};

$(document).ready(function(){
  if ($("#link-table").length > 0) {
    var table = $("#link-table").DataTable({
      language: language,
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: location.href,
      columns: [
        {data: 'id'},
        {data: 'name', name: 'name'},
        {data: 'shortlnk', name: 'shortlnk'},
        {data: 'destination', name: 'destination'},
        {data: 'stt', name: 'stt'},
        {data: 'created', name: 'created'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
        {data: 'shortlink', name: 'shortlink',visible: false},
      ],
      "language": language,
      'drawCallback': function(settings){
        $(".confirm").on('click',function(){
          var txt = $(this).data('text');
          if (!confirm(txt)) {
            return false;
          }
        });
        $(".get-link").click(function(e){
          e.stopPropagation();
          e.stopImmediatePropagation();
          var $tempElement = $("<input>");
          $("body").append($tempElement);
          $tempElement.val($(this).text()).select();
          document.execCommand("Copy");
          $tempElement.remove();
          alert("Link "+$(this).closest('tr').find('td:nth-child(2)').text()+" berhasil di salin!");
        })
      }
    });

    table.on( 'draw.dt', function () {
      var PageInfo = $('.dataTable').DataTable().page.info();
      table.column(0, {search: 'applied', order: 'applied', page: 'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = (i+1+PageInfo.start)+'.';
      });
    }).draw();
  }

  if ($(".notif").length > 0) {
    setTimeout(()=>{
      $(".notif").fadeOut();
    },5000)
  }
})
