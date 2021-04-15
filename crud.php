<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>CRUD</title>
  </head>
  <body>
	<?php
	$sunucu_adi = "localhost";
	$kullanici_adi= "root";
	$sifre = "";
	$vt = "crudsql";

	$baglanti = new mysqli($sunucu_adi, $kullanici_adi, $sifre, $vt);

	mysqli_set_charset($baglanti,"utf8");

	if ($baglanti->connect_error)
		die("Bağlantı sağlanamadı".$baglanti->connect_error);
	?>
	<?php
		if(isset($_POST["bc_kaydet"]))
		{
		$sql = "INSERT INTO	`kullanici`	(`id`, `kullanici_adi`, `sifre`, `eposta`)	VALUES 	(NULL, '".$_POST['bc_kullanici_adi']."', '".$_POST['bc_sifre']."', '".$_POST['bc_eposta']."')";
		$baglanti->query($sql);
		header('Location: crud.php');
		}
		else if(isset($_POST["bc_guncelle"]))
		{
		$sorgu="UPDATE `kullanici` SET `kullanici_adi` = '".$_POST['bc_kullanici_adi']."', `sifre` = '".$_POST['bc_sifre']."', `eposta` = '".$_POST['bc_eposta']."' WHERE `kullanici`.`id` = ".$_POST['bc_kayit_no'].";";		
		$baglanti->query($sorgu);
		}
		else if(isset($_POST["bc_sil"]))
		{
			$sorgu="DELETE FROM `kullanici` WHERE `kullanici`.`id` = ".$_POST['bc_kayit_no'];
			$baglanti->query($sorgu);			
		}
		else if(isset($_POST["bc_duzenle"]))
		{
			$sorgu="SELECT * FROM `kullanici` WHERE `id` = ".$_POST['bc_kayit_no'];
			$sonuc=$baglanti->query($sorgu);	
			$kayit=$sonuc->fetch_assoc();
		}
		
	?>
    <h1><br></br></h1>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<?php
				if(!isset($_POST["bc_duzenle"]))
				{
			?>
				<form action="" method="POST">
					<div class="form-group row">
						<label for="kullanici_adi" class="col-sm-2 col-form-label">&nbsp;&nbsp;Kullanıcı Adı :</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="kullanici_adi" name="bc_kullanici_adi" placeholder="Kullanıcı adınızı giriniz.." style="font-style:italic" autofocus required>
						</div>
					</div>
					<div class="form-group row">
						<label for="sifre" class="col-sm-2 col-form-label">&nbsp;&nbsp;Şifre :</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="sifre" name="bc_sifre" placeholder="Şifrenizi giriniz.." style="font-style:italic" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="eposta" class="col-sm-2 col-form-label">&nbsp;&nbsp;E-Posta :</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="eposta" name="bc_eposta" placeholder="E-Posta adresinizi giriniz.." style="font-style:italic" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="eposta" class="col-sm-2 col-form-label"></label>	
						<div class="col-sm-10">	
							<button type="submit" class="btn btn-primary" value="kaydet" name="bc_kaydet">Kaydet</button>						
							<button type="reset" class="btn btn-dark" value="temizle" name="bc_temizle">Temizle</button><br></br>						
						</div>
					</div>
				</form>
				<?php
				}
				else
				{
				?>			
				<form action="" method="POST">
					<div class="form-group row">
						<label for="kullanici_adi" class="col-sm-2 col-form-label">&nbsp;&nbsp;Kullanıcı Adı :</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="kullanici_adi" name="bc_kullanici_adi" value="<?=$kayit["kullanici_adi"]?>" autofocus required>
						</div>
					</div>
					<div class="form-group row">
						<label for="sifre" class="col-sm-2 col-form-label">&nbsp;&nbsp;Şifre :</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="sifre" name="bc_sifre" required value="<?=$kayit["sifre"]?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="eposta" class="col-sm-2 col-form-label">&nbsp;&nbsp;E-Posta :</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="eposta" name="bc_eposta" required value="<?=$kayit["eposta"]?>" >
						</div>
					</div>
					<div class="form-group row">
						<label for="eposta" class="col-sm-2 col-form-label"></label>	
						<div class="col-sm-10">	
							<input type="hidden" name="bc_kayit_no" value="<?=$kayit["id"]?>">
							<button type="submit" class="btn btn-warning" value="güncelle" name="bc_guncelle">Güncelle</button>	
							<button type="reset" class="btn btn-info" value="ilk_haline_don" name="bc_ilk_haline_don">İlk Haline Dön</button><br></br>		
						</div>
					</div>
				</form>
				<?php
				}
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped">
					<thead>
							<tr>
								<th scope="col">#<br /></th>
								<th scope="col"><u>Kullanıcı Adı</u><br /></th>
								<th scope="col"><u>Sifre</u><br /></th>
								<th scope="col"><u>E-Posta</u><br /></th>
							</tr>
					</thead>
					<tbody>
					<?php
						$sorgu="SELECT * FROM `kullanici`";
						$sonuc=$baglanti->query($sorgu);
						$i=0;
						while($kayit=$sonuc->fetch_assoc())
						{	
							$i++;
					?>
						<tr>
							<th scope="row"><?=$i."."?></th>
							<td><?=$kayit["kullanici_adi"]?></td>
							<td><?=$kayit["sifre"]?></td>
							<td><?=$kayit["eposta"]?></td>
							<td>
								<form action="" method="post">
									<input type="hidden" name="bc_kayit_no" value="<?=$kayit["id"]?>">
									<button type="submit" class="btn btn-success" value="duzenle" name="bc_duzenle">Düzenle</button>
									<button type="submit" class="btn btn-danger" value="sil" name="bc_sil">Sil</button>
								</form>
							</td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  </body>
</html>