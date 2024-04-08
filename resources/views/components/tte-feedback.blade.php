<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Detail Surat</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <style>
      .card {
         border-radius: 20px;
      }
   </style>
</head>
<body>
   <div class="container mt-5">
      <div class="row justify-content-center">
         <div class="col-md-6">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Detail DTKS</h5>
                  <div class="form-group">
                     <label for="namaPemohon">Nama Pemohon:</label>
                     <input type="text" class="form-control" id="namaPemohon" value="Dama" readonly>
                  </div>
                  <div class="form-group">
                     <label for="perihal">Perihal:</label>
                     <input type="text" class="form-control" id="perihal" value="Permohonan Izin" readonly>
                  </div>
                  <div class="form-group">
                     <label for="ditandatangani">Ditandatangani oleh:</label>
                     <input type="text" class="form-control" id="ditandatangani" value="Dr. Ahmad" readonly>
                  </div>
                  <div class="form-group">
                     <label for="waktuDitandatangani">Waktu Ditandatangani:</label>
                     <input type="text" class="form-control" id="waktuDitandatangani" value="2024-04-05 10:00:00" readonly>
                  </div>
                  <div class="form-group">
                     <label>Unduh File DTKS:</label><br>
                     <a href="file-dtks.pdf" download class="btn btn-primary">Unduh</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
