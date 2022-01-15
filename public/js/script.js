$(function () {
  $(".tombolTambahData").on("click", function () {
    $("#judulModal").html("Tambah Data Mahasiswa");
    $("#nama").val("");
    $("#nrp").val("");
    $("#email").val("");
    $("#jurusan").val("");
    $(".modal-footer button[type=submit]").html("Tambah Data");
    $(".modal-body form").attr("action", "http://localhost/phpmvc/public/mahasiswa/tambah");
  });

  $(".tampilModalUbah").on("click", function () {
    $("#judulModal").html("Ubah Data Mahasiswa");
    $(".modal-footer button[type=submit]").html("Ubah Data");
    $(".modal-body form").attr("action", "http://localhost/phpmvc/public/mahasiswa/ubah");

    const id = $(this).data("id");

    $.ajax({
      url: "http://localhost/phpmvc/public/mahasiswa/getubah",
      data: { id: id },
      method: "post",
      dataType: "json",
      success: function (data) {
        $("#nama").val(data.nama);
        $("#nrp").val(data.nrp);
        $("#email").val(data.email);
        $("#jurusan").val(data.jurusan);
        $("#id").val(data.id);
      },
    });
  });

  $("#cari").on("keyup", function () {
    console.log($("#cari").val());

    const cari = $("#cari").val();
    $.ajax({
      url: "http://localhost/phpmvc/public/mahasiswa/cariData",
      data: { cari: cari },
      method: "post",
      dataType: "json",
      success: function (data) {
        console.log(data);
        $(".tampilDataCari").html("<li></li>");
      },
    });
  });
});
