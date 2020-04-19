<?php

	session_start();
	// print_r($_SESSION);
	// echo session_id();

	if(isset($_SESSION['auth'])) {
		header("Location: paymenthistory.php");
	}

	if(!empty($_POST['username']) && !empty($_POST['password'])) {
		include 'include/db/user.class.php';

		$userClass = new User();
    	$loggedUser = $userClass->getLogin($_POST['username'],$_POST['password']);
//        print_r($loggedUser['admin']); ez jo!
		if($loggedUser) {
			$_SESSION['auth'] = true;
			$_SESSION['username'] = $loggedUser['user'];
			$_SESSION['admin'] = $loggedUser['admin'];
			header("Location: paymenthistory.php");
		}
	}

	
	include 'include/views/head.php';
?>
<body>
<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
                        <img src="/InternalPayments/logo.png" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form method="post">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="username" class="form-control input_user" value="" placeholder="username">
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password" class="form-control input_pass" value="" placeholder="password">
						</div>
						<div class="form-group">
						</div>
						<div class="d-flex justify-content-center mt-3 login_container">
					<button type="submit" name="button" class="btn login_btn">Login</button>
				</div>						
					</form>
				</div>

				<div class="mt-4">
				</div>
			</div>
		</div>
    </div>
</body>
</html>




