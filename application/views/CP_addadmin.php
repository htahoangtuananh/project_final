<div class="col-md-9">
				<div class="row">
	  				<div class="col-md-12">
	  					<div class="content-box-large">
			  				<div class="panel-heading">
					            <div class="panel-title para-title">Thêm admin</div>
					        </div>
			  				<div class="panel-body form-horizontal">
							<?php echo validation_errors(); ?>
								<?php echo form_open('Admin/addadminsubmit'); ?>
									<div class="form-group">
									<label for="label" class="text-align-left col-md-2 control-label">Tên đăng nhập</label>
										<div class="col-md-7">
											<input type="text" name="username" class="form-control number-field">
										</div>
									</div>
									<div class="form-group">
									<label for="choose" class="text-align-left col-md-2 control-label">Vai trò</label>
										<div class="col-md-5">
											<select id="choose-role" name="role" class="form-control type" >
												<option value="gadmin" >gadmin</option>
												<option value="admin" >admin</option>
										  </select>
										</div>
									</div>
									<div class="form-group">
									<label for="label" class="text-align-left col-md-2 control-label">Mật khẩu</label>
										<div class="col-md-7">
											<input type="text" name="password" class="form-control number-field">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-2 col-md-10">
										  <button type="submit" class="btn btn-primary">Cập nhật</button>
										</div>
									</div>
							</div>
			  			</div>
			  		</div>
	  			</div>
			</div>
		</div>
	</div>