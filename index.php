<!DOCTYPE html>
<html>
<head>
  <title>Aplikasi Antrian</title>
</head>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
<?php
  function terbilang($bilangan) {

    $angka = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
    $kata = array('','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan');
    $tingkat = array('','ribu','juta','milyar','triliun');
    $panjang_bilangan = strlen($bilangan);

    /* pengujian panjang bilangan */
    if ($panjang_bilangan > 15) {
      $kalimat = "Diluar Batas";
      return $kalimat;
    }
    /* mengambil angka-angka yang ada dalam bilangan,
       dimasukkan ke dalam array */
    for ($i = 1; $i <= $panjang_bilangan; $i++) {
      $angka[$i] = substr($bilangan,-($i),1);
    }
    $i = 1;
    $j = 0;
    $kalimat = "";

    /* mulai proses iterasi terhadap array angka */
    while ($i <= $panjang_bilangan) {

      $subkalimat = "";
      $kata1 = "";
      $kata2 = "";
      $kata3 = "";

      /* untuk ratusan */
      if ($angka[$i+2] != "0") {
        if ($angka[$i+2] == "1") {
          $kata1 = "seratus";
        } else {
          $kata1 = $kata[$angka[$i+2]] . " ratus";
        }
      }

      /* untuk puluhan atau belasan */
      if ($angka[$i+1] != "0") {
        if ($angka[$i+1] == "1") {
          if ($angka[$i] == "0") {
            $kata2 = "sepuluh";
          } elseif ($angka[$i] == "1") {
            $kata2 = "sebelas";
          } else {
            $kata2 = $kata[$angka[$i]] . " belas";
          }
        } else {
          $kata2 = $kata[$angka[$i+1]] . " puluh";
        }
      }

      /* untuk satuan */
      if ($angka[$i] != "0") {
        if ($angka[$i+1] != "1") {
          $kata3 = $kata[$angka[$i]];
        }
      }

      /* pengujian angka apakah tidak nol semua,
         lalu ditambahkan tingkat */
      if (($angka[$i] != "0") OR ($angka[$i+1] != "0") OR
          ($angka[$i+2] != "0")) {
        $subkalimat = "$kata1 $kata2 $kata3 " . $tingkat[$j] . " ";
      }

      /* gabungkan variabe sub kalimat (untuk satu blok 3 angka)
         ke variabel kalimat */
      $kalimat = $subkalimat . $kalimat;
      $i = $i + 3;
      $j = $j + 1;
    }
	
    /* mengganti satu ribu jadi seribu jika diperlukan */
    if (($angka[5] == "0") AND ($angka[6] == "0")) {
      $kalimat = str_replace("satu ribu","seribu",$kalimat);
		}
    return trim($kalimat);
	}
	$noLoket='0';
	$tLoket='';
	
	/*memindahkan variabel untuk di konversi ke kalimat*/
	if(isset($_POST['loket'])){
		$noLoket=$_POST['loket'];
		$tLoket=terbilang($noLoket);
	}
	$press='';
  
  /* fungsi decrement jika antrian bernilai 0 tidak bisa dikurangi*/
	function PRV($antr){
			if($antr<=0){
				$antr=0;
			}else{
				$antr-=1;
			}
		return $antr;
	}
	
	$jumLoket=5;
	
	if(isset($_POST['btn'])){
		$press=$_POST['btn'];
	  }
	
  $antrian=0;
  
	if(isset($_POST['antrian'])){
		$antrian=$_POST['antrian'];
	}
  $display=$antrian;
  $terbilangTxt=terbilang($display);
  
  if($press=='next'){
    $antrian+=1;
    $display=$antrian;
    $terbilangTxt=terbilang($display);
  }elseif($press=='prev'){
    $antrian=PRV($antrian);
    $display=$antrian;
    $terbilangTxt=terbilang($display);
  }elseif($press=='reset'){
	  $display=0;
  }
  ?>
<center>
<div id="container">
  <form method="POST" action="" name="antri">
  <br><br><br>
  <div class="kolom-input">
	<label for="antrian">Antrian</label><br>
	<input type="text" id="antrian" name="antrian" class="inputan" value="<?php echo $display;?>">
  </div>
    <div class="kolom-input right">
	<label for="Loket">Loket</label><br>
	<select id="loket" class="inputan" name="loket">
	<?php
	for($i=1;$i<=$jumLoket;$i++)
		echo "<option value=\"$i\">$i</option>";
	?>
  </select>
  </div>
	  <br><br><br><br><br><br>
	  <div id="kolom-submit">
	  <input type="submit" class="btn" name="btn" value="prev">&nbsp;&nbsp;
	  <input type="submit" class="btn" name="btn" value="next">&nbsp;&nbsp;
	  <input type="submit" class="btn" name="btn" value="reset">
	  </div>
	  <br><br>
	 <?php
	  $tmp=explode(' ',$terbilangTxt);
	  ?>
	<label for="bg-status">NOW SERVING</label>
	<div id="bg-status">
	  <hr>
	  <marquee direction="left">
	<h1>
	<?php
	  if($display=='0')
		echo "Tidak Ada Antrian";
	  else
		echo "Antrian : ".$terbilangTxt." di loket ".$noLoket."."; ?></h1>
	</marquee>
	<hr>
	</div>
	</form>
	<div>Nama : Andika Maulana <br>
		NIM : 5150411222<br>
		&copy;2018
	</div>
	</center>
	</div>
	<audio id="audioplayer" autoplay>
		<source src="<?php if($display!='0'){echo "audio/antri_open.mp3";}?>">
	</audio>
<script type="text/javascript">
    var songs = ["audio/nomor_antrian.mp3",<?php
	/*memasukan nomor antrian berupa kata ke array */
    foreach ($tmp as $antri){
      if($antri!='')
		echo "\"audio/".$antri.".mp3\",";
      }?>"audio/di_loket.mp3","audio/<?php echo $tLoket;?>.mp3","audio/antri_close.mp3"];
      var ln=songs.length;
      var i=0;
      var audio = document.getElementById("audioplayer");
      audio.addEventListener("ended", function() {
          var getAudio = this.getAttribute("src");
          var getPos = songs.indexOf(getAudio);
          if(i<ln){
          audio.src =songs[i];
          i++;
          audio.play();
        }
      });
  </script>
</body>
</html>
