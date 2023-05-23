<html lang="en"><head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="/rocker/assets/images/favicon-32x32.png" type="image/png">
	<!--plugins-->
	<link href="/rocker/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
	<link href="/rocker/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
	<link href="/rocker/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
	<!-- loader-->
	<link href="/rocker/assets/css/pace.min.css" rel="stylesheet">
	<script src="/rocker/assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="/rocker/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/rocker/assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="/rocker/https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="/rocker/assets/css/app.css" rel="stylesheet">
	<link href="/rocker/assets/css/icons.css" rel="stylesheet">
	<title>Rocker - Bootstrap 5 Admin Dashboard Template</title>
</head>

<body class="bg-login  pace-done"><div class="pace  pace-inactive"><div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
  <div class="pace-progress-inner"></div>
</div>
<div class="pace-activity"></div></div>
	<!--wrapper-->
	<div class="wrapper" id="app">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-4">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="card mt-5 mt-lg-0">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class=""><b style = "font-family:courier,arial,helvetica;">Quên Mật Khẩu</b></h3>
									</div>
									<div class="form-body">
										<form class="row g-3" action="/admin/loss-password" method="post">
                                            @csrf
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label"><b>Địa Chỉ Email</b></label>
												<input name="email" type="email" class="form-control" id="inputEmailAddress" placeholder="Email Address">
											</div>
											<div class="col-md-6">

											</div>
											<div class="col-md-6 text-end">
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary" style = "font-family:courier,arial,helvetica;"><i class="bx bxs-lock-open"></i><b>Lấy Lại Mật Khẩu</b></button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="/rocker/assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="/rocker/assets/js/jquery.min.js"></script>
	<script src="/rocker/assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="/rocker/assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="/rocker/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			})

		});
	</script>
	<!--app JS-->
	<script src="/rocker/assets/js/app.js"></script>


</body></html>
