$(function() {
    // event listener untuk button tampilkan modal
    $("#tampilkan-modal").click(function() {
      // tampilkan modal
      $("#modal-input").modal("show");
    });

    // event listener untuk inputan nama
    $("#nama").on("input", function() {
      // cek apakah inputan nama sudah terisi
      if ($(this).val()) {
        // enable button submit
        $("#submit").prop("disabled", false);
      } else {
        // disable button submit
        $("#submit").prop("disabled", true);
      }
    });

    // event listener untuk inputan file
    $("#file").on("change", function() {
      // cek apakah inputan file sudah dipilih
      if ($(this).val()) {
        // enable button submit
        $("#submit").prop("disabled", false);
      } else {
        // disable button submit
        $("#submit").prop("disabled", true);
      }
    });
  });
