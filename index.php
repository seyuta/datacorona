<?php
$apiDaily = file_get_contents('https://services5.arcgis.com/VS6HdKS0VfIhv8Ct/arcgis/rest/services/Statistik_Perkembangan_COVID19_Indonesia/FeatureServer/0/query?where=Jumlah_Kasus_Kumulatif%20%3E%3D%201%20AND%20Jumlah_Kasus_Kumulatif%20%3C%3D%201000000&outFields=*&returnGeometry=false&outSR=&f=json');
$jsonDaily = json_decode($apiDaily);
$apiEndProv = file_get_contents('https://services5.arcgis.com/VS6HdKS0VfIhv8Ct/arcgis/rest/services/COVID19_Indonesia_per_Provinsi/FeatureServer/0/query?where=1%3D1&outFields=Provinsi,Kasus_Posi,Kasus_Semb,Kasus_Meni&returnGeometry=false&orderByFields=Kasus_Posi%20DESC&outSR=&f=json');
$getJsonProv = json_decode($apiEndProv);

$getUpdate = end($jsonDaily->features);
$kasusPositif = $getUpdate->attributes->Jumlah_Kasus_Kumulatif;
$posiNewDaily = $getUpdate->attributes->Jumlah_Kasus_Baru_per_Hari;
$sembuh = $getUpdate->attributes->Jumlah_Pasien_Sembuh;
$sembNewDaily = $getUpdate->attributes->Jumlah_Kasus_Sembuh_per_Hari;
$sembPersen = $getUpdate->attributes->Persentase_Pasien_Sembuh;
$dirawat = $getUpdate->attributes->Jumlah_pasien_dalam_perawatan;
$dirawatNewDaily = $getUpdate->attributes->Jumlah_Kasus_Dirawat_per_Hari;
$dirawatPersen = $getUpdate->attributes->Persentase_Pasien_dalam_Perawatan;
$meninggal = $getUpdate->attributes->Jumlah_Pasien_Meninggal;
$meniNewDaily = $getUpdate->attributes->Jumlah_Kasus_Meninggal_per_Hari;
$meniPersen = $getUpdate->attributes->Persentase_Pasien_Meninggal;

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162528223-2"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-162528223-2');
	</script>

	<base href="./">
	<meta charset="utf-8" />
	<title>Data Covid-19 | Indonesia</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link rel="icon" href="assets/fav.ico">

	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="assets/css/app.min.css" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
</head>

<body>
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>

	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<div id="header" class="header navbar-default">
			<div class="navbar-header">
				<a href="#" class="navbar-brand">
					<img src="assets/logo.png" alt="">
					Data Covid-19 Indonesia
				</a>
			</div>
			<ul class="navbar-nav navbar-right">
				<li class="navbar-form">
					<form>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Update : <?php echo date("d F Y", $getUpdate->attributes->Tanggal / 1000)?> 16:00 WIB" disabled>
						</div>
					</form>
				</li>
			</ul>
		</div>

		<div class="container mt-3">
			<h1 class="page-header"><small>Sumber Data : Badan Nasional Penanggulangan Bencana (BNPB)</small></h1>
			<div class="row">
				<div class="col-md-3">
					<div class="row">
						<div class="col-md-12">
							<div class="card border-0 text-truncate mb-3 bg-dark text-white">
								<div class="card-body">
									<div class="text-center">
										<h4 class="text-white mb-2"><b>Data Nasional</b></h4>
									</div>
									<div class="d-flex mb-2 mt-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
											Kasus Positif
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												<span data-animation="number" data-value="<?php echo $kasusPositif ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-secondary f-s-8 mr-2"></i>
											Dirawat
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="text-grey f-s-11">(<span data-animation="number" data-value="<?php echo number_format($dirawatPersen, 2) ?>"></span> %)</div>
											<div class="f-s-18 text-right pl-2 f-w-600">
												<span data-animation="number" data-value="<?php echo $dirawat ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-lime f-s-8 mr-2"></i>
											Sembuh
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="text-grey f-s-11">(<span data-animation="number" data-value="<?php echo number_format($sembPersen, 2) ?>"></span> %)</div>
											<div class="f-s-18 text-right pl-2 f-w-600">
												<span data-animation="number" data-value="<?php echo $sembuh ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-red f-s-8 mr-2"></i>
											Meninggal
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="text-grey f-s-11">(<span data-animation="number" data-value="<?php echo number_format($meniPersen, 2) ?>"></span> %)</div>
											<div class="f-s-18 text-right pl-2 f-w-600">
												<span data-animation="number" data-value="<?php echo $meninggal ?>"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="row">
						<div class="col-md-12">
							<div class="card border-0 text-truncate mb-3 bg-dark text-white">
								<div class="card-body">
									<div class="text-center">
										<h4 class="text-white mb-2"><b>Data Hari Ini</b></h4>
									</div>
									<div class="d-flex mb-2 mt-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
											Kasus Positif
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												+
												<span data-animation="number" data-value="<?php echo $posiNewDaily ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-secondary f-s-8 mr-2"></i>
											Dirawat
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												+
												<span data-animation="number" data-value="<?php echo $dirawatNewDaily ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-lime f-s-8 mr-2"></i>
											Sembuh
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												+
												<span data-animation="number" data-value="<?php echo $sembNewDaily ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-red f-s-8 mr-2"></i>
											Meninggal
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												+
												<span data-animation="number" data-value="<?php echo $meniNewDaily ?>"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container" id="provinsi">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Data Provinsi</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<?php foreach ($getJsonProv->features as $provinsi) { ?>
							<div class="col-md-3" <?php echo $provinsi->attributes->Provinsi == 'Indonesia' ? 'hidden' : '' ?>>
								<div class="row">
									<div class="col-md-12">
										<div class="card border-0 text-truncate mb-3 bg-dark text-white">
											<div class="card-body">
												<div class="text-center">
													<h4 class="text-white mb-2"><b><?php echo $provinsi->attributes->Provinsi ?></b></h4>
												</div>
												<div class="d-flex mb-2 mt-2">
													<div class="d-flex f-s-16 align-items-center">
														<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
														Kasus Positif
													</div>
													<div class="d-flex align-items-center ml-auto">
														<div class="f-s-18 text-right pl-2 f-w-600">
															<span data-animation="number" data-value="<?php echo $provinsi->attributes->Kasus_Posi ?>"></span>
														</div>
													</div>
												</div>
												<div class="d-flex mb-2">
													<div class="d-flex f-s-16 align-items-center">
														<i class="fa fa-circle text-lime f-s-8 mr-2"></i>
														Sembuh
													</div>
													<div class="d-flex align-items-center ml-auto">
														<div class="text-grey f-s-11">(<span data-animation="number" data-value="<?php echo number_format($provinsi->attributes->Kasus_Semb / $provinsi->attributes->Kasus_Posi * 100, 2) ?>"></span> %)</div>
														<div class="f-s-18 text-right pl-2 f-w-600">
															<span data-animation="number" data-value="<?php echo $provinsi->attributes->Kasus_Semb ?>"></span>
														</div>
													</div>
												</div>
												<div class="d-flex mb-2">
													<div class="d-flex f-s-16 align-items-center">
														<i class="fa fa-circle text-red f-s-8 mr-2"></i>
														Meninggal
													</div>
													<div class="d-flex align-items-center ml-auto">
														<div class="text-grey f-s-11">(<span data-animation="number" data-value="<?php echo number_format($provinsi->attributes->Kasus_Meni / $provinsi->attributes->Kasus_Posi * 100, 2) ?>"></span> %)</div>
														<div class="f-s-18 text-right pl-2 f-w-600">
															<span data-animation="number" data-value="<?php echo $provinsi->attributes->Kasus_Meni ?>"></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<div class="container mb-5 mt-3">
			© 2020 - <a href="http://seyuta.online/">Seyuta Asagung H</a>
		</div>

		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="assets/js/app.min.js"></script>
	<script src="assets/js/default.js"></script>
	<!-- ================== END BASE JS ================== -->
</body>

</html>