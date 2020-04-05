<!DOCTYPE html>
<html lang="en">

<head>
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
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>
	<!-- end #page-loader -->

	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<div id="header" class="header navbar-default">
			<!-- begin navbar-header -->
			<div class="navbar-header">
				<a href="#" class="navbar-brand">
					<img src="assets/logo.png" alt="">
					Data Covid-19 Indonesia
				</a>
			</div>
			<!-- end navbar-header -->
			<?php
			$apiKemkes = file_get_contents('https://covid-monitoring2.kemkes.go.id/summary/daily');
			$jsonDaily = json_decode($apiKemkes, true);
			$getUpdate = end($jsonDaily);
			$date = date_create($getUpdate['tanggal']);
			$jumlahKasus = $getUpdate['jumlah_kasus'];
			$sembuh = $getUpdate['sembuh'];
			$dirawat = $getUpdate['dirawat'];
			$meninggal = $getUpdate['meninggal'];
			?>
			<ul class="navbar-nav navbar-right">
				<li class="navbar-form">
					<form>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Update : <?php echo date_format($date, "d F Y H:i:s") ?>" disabled>
							<!-- <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button> -->
						</div>
					</form>
				</li>
			</ul>
		</div>

		<?php
		$apiProv = file_get_contents('https://covid-monitoring2.kemkes.go.id/summary/provinces');
		$getProv = json_decode($apiProv, true);
		$apiPasien = file_get_contents('https://covid-monitoring2.kemkes.go.id/surveillance');
		$getPasien = json_decode($apiPasien, true);

		$under20 = [];
		$umur20an = [];
		$umur30an = [];
		$umur40an = [];
		$above50 = [];
		$umurNull = [];
		foreach ($getPasien as $value) {
			if ($value['umur'] < 20 && $value['umur'] != null) array_push($under20, $value['umur']);
			if ($value['umur'] >= 20 && $value['umur'] < 30) array_push($umur20an, $value['umur']);
			if ($value['umur'] >= 30 && $value['umur'] < 40) array_push($umur30an, $value['umur']);
			if ($value['umur'] >= 40 && $value['umur'] < 50) array_push($umur40an, $value['umur']);
			if ($value['umur'] > 50 && $value['umur'] != null) array_push($above50, $value['umur']);
			if ($value['umur'] == null) array_push($umurNull, $value['umur']);
		}
		?>

		<div class="container mt-3">
			<h1 class="page-header"><small>Sumber Data : Kementrian Kesehatan Republik Indonesia</small></h1>
			<div class="row">
				<div class="col-md-3">
					<div class="row">
						<div class="col-md-12">
							<div class="card border-0 text-truncate mb-3 bg-dark text-white">
								<div class="card-body">
									<div class="text-center">
										<h4 class="text-white mb-2"><b>Nasional</b></h4>
									</div>
									<div class="d-flex mb-2 mt-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
											Kasus Positif
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												<span data-animation="number" data-value="<?php echo $jumlahKasus ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-blue f-s-8 mr-2"></i>
											Dirawat
										</div>
										<div class="d-flex align-items-center ml-auto">
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
											<div class="text-grey f-s-11">(<span data-animation="number" data-value="<?php echo number_format($sembuh / $jumlahKasus * 100, 2) ?>"></span> %)</div>
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
											<div class="text-grey f-s-11">(<span data-animation="number" data-value="<?php echo number_format($meninggal / $jumlahKasus * 100, 2) ?>"></span> %)</div>
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
										<h4 class="text-white mb-2"><b>Data Umur</b></h4>
									</div>
									<div class="d-flex mb-2 mt-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
											Dibawah 20 Thn
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												<span data-animation="number" data-value="<?php echo count($under20) ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2 mt-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
											20-29 Thn
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												<span data-animation="number" data-value="<?php echo count($umur20an) ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2 mt-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
											30-40 Thn
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												<span data-animation="number" data-value="<?php echo count($umur30an) ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2 mt-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
											40-50 Thn
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												<span data-animation="number" data-value="<?php echo count($umur40an) ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2 mt-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
											Diatas 50 Thn
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												<span data-animation="number" data-value="<?php echo count($above50) ?>"></span>
											</div>
										</div>
									</div>
									<div class="d-flex mb-2 mt-2">
										<div class="d-flex f-s-16 align-items-center">
											<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
											Tidak Diketahui
										</div>
										<div class="d-flex align-items-center ml-auto">
											<div class="f-s-18 text-right pl-2 f-w-600">
												<span data-animation="number" data-value="<?php echo count($umurNull) ?>"></span>
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
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-plus"></i></a>
					</div>
				</div>
				<div class="panel-body" style="display:none;">
					<div class="row">
						<?php foreach ($getProv as $provinsi) { ?>
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-12">
										<div class="card border-0 text-truncate mb-3 bg-dark text-white">
											<div class="card-body">
												<div class="text-center">
													<h4 class="text-white mb-2"><b><?php echo $provinsi['nama_provinsi'] ?></b></h4>
												</div>
												<div class="d-flex mb-2 mt-2">
													<div class="d-flex f-s-16 align-items-center">
														<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
														Jumlah Pasien
													</div>
													<div class="d-flex align-items-center ml-auto">
														<div class="f-s-18 text-right pl-2 f-w-600">
															<span data-animation="number" data-value="<?php echo $provinsi['count'] ?>"></span>
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

		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="assets/js/app.min.js"></script>
	<script src="assets/js/default.js"></script>
	<!-- ================== END BASE JS ================== -->
</body>

</html>