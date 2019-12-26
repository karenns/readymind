<?php
session_start();
if($_SESSION['user']){
		
}
else{
	header("location:index.php");
}
$user_id = $_SESSION['user'];
?>

<?php
include 'header.php';
create_header('profile');
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Profile</h2></center> 
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
				<!-- Panel Profile -->
				<div class="panel panel-default">
				<!--<div class="panel-heading">
                     Customer
					</div>-->
					<div class="panel-body">
					    <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <form role="form" method="post">
									<div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" maxlength="100" required="required"/>
										
                                    </div>
									<p class="help-block">*The email will be used to access the system</p>
									<!--<div class="form-group">
                                        <label>Sheer Red UserID</label>
                                        <input type="text" name="user_id" class="form-control" placeholder="Choose an userID" required="required"/>
                                    </div>-->
																		                                   <div class="form-group input-group">
                                        <input type="text" name="user_id" class="form-control" placeholder="email" maxlength="50" required="required">
										<span class="input-group-addon">@sheerindustries.com</span>
										
                                    </div>
									
							        <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password1" class="form-control" maxlength="20" required="required"/>
                                    </div>
									<div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password2" class="form-control" maxlength="20" required="required"/>
                                    </div>
									
								<br>
								<button type="submit" name="submit" class="btn btn-primary">Create</button>
                                </form>

                            </div>
                        </div>
					</div>
				</div>
				<!-- /. Panel Profile-->
			</div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->

<?php
include 'footer.php';
?>
