
<div class="col-lg-12">
	<h2 class="text-center"><b>Contact Us</b></h2>
	<div class="card card-outline card-info">
		<div class="card-body">
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-4 offset-sm-2">
						<div class="card shadow-lg">
							<div class="card-body">
								<div class="d-flex justify-content-center w-100">
									<span class="img-circle border-info shadow-lg elevation-2 d-flex justify-content-center align-items-center"  style="width: 75px;height:75px;border: 5px solid ">
										<span class="fa fa-at text-info" style="font-size: 3rem"></span>
									</span>
								</div>
								<div class="text-center">
									<b><?php echo $_SESSION['system']['email'] ?></b>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="card shadow-lg">
							<div class="card-body">
								<div class="d-flex justify-content-center w-100">
									<span class="img-circle border-info shadow-lg elevation-2 d-flex justify-content-center align-items-center"  style="width: 75px;height:75px;border: 5px solid ">
										<span class="fa fa-phone-alt text-info" style="font-size: 3rem"></span>
									</span>
								</div>
								<div class="text-center">
									<b><?php echo $_SESSION['system']['contact'] ?></b>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 offset-sm-4">
						<div class="card shadow-lg">
							<div class="card-body">
								<div class="d-flex justify-content-center w-100">
									<span class="img-circle border-info shadow-lg elevation-2 d-flex justify-content-center align-items-center"  style="width: 75px;height:75px;border: 5px solid ">
										<span class="fa fa-map-marker-alt text-info" style="font-size: 3rem"></span>
									</span>
								</div>
								<div class="text-center">
									<b><?php echo $_SESSION['system']['address'] ?></b>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>