<html lang="en"><head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="/rocker/assets/images/favicon-32x32.png" type="image/png">
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

<body class="  pace-done"><div class="pace  pace-inactive"><div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
  <div class="pace-progress-inner"></div>
</div>
<div class="pace-activity"></div></div>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-reset-password d-flex align-items-center justify-content-center">
			<div class="row">
				<div class="col-12 col-lg-10 mx-auto">
					<div class="card">
						<div class="row g-0">
							<div class="col-lg-5 border-end">
								<div class="card-body">
                                    <form action="/admin/update-password" method="post">
                                        @csrf
                                        <div class="p-5">
                                            <div class="text-start">
                                                <img src="/rocker/assets/images/logo-img.png" width="180" alt="">
                                            </div>
                                            <h4 class="mt-5 font-weight-bold">Tạo Mật Khẩu Mới</h4>
                                            <p class="text-muted">Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu của bạn. Vui lòng nhập mật khẩu mới của bạn!</p>

                                            <div class="mb-3 mt-5">
                                                <input name="hash_reset" type="text" hidden class="form-control" value="{{$hash_reset}}">
                                                <label class="form-label">Mật Khẩu Mới</label>
                                                <input name="password" type="text" class="form-control" placeholder="Nhập Mật Khẩu Mới *">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nhập Lại Mật Khẩu</label>
                                                <input name="re_password" type="text" class="form-control" placeholder="Nhập Lại Mật Khẩu *">
                                            </div>
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-primary">Xác Nhận Mật Khẩu</button> <a href="/admin/login" class="btn btn-light"><i class="bx bx-arrow-back mr-1"></i>Đăng Nhập</a>
                                            </div>
                                        </div>
                                    </form>

								</div>
							</div>
							<div class="col-lg-7">
								<img src="/rocker/assets/images/login-images/forgot-password-frent-img.jpg" class="card-img login-img h-100" alt="...">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->


</body></html>
