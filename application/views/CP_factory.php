			<div class="col-md-9">
				<div class="row">
	  				<div class="col-md-6">
	  					<div class="content-box-large">
			  				<div class="panel-heading">
					            <div class="panel-title para-title">Thêm sửa nhà máy</div>
					        </div>
			  				<div class="panel-body form-horizontal">
							<?php echo validation_errors(); ?>
								<?php echo form_open('Admin/addfactorysubmit'); ?>
									<div class="form-group">
										<label for="choose" class="text-align-left col-md-3 control-label">Chọn</label>
										<div class="col-md-9">
											<select id="choose" class="form-control" >
											<option> </option>
											<?php for($i=0;$i<count($factory);++$i):?>
											<option> <?php echo $factory[$i]['factory_id']?> | <?php echo $factory[$i]['factory_name']?> | <?php echo $factory[$i]['manufacturing_id']?> | <?php echo $factory[$i]['location_code']?> | <?php echo $factory[$i]['capacity']?> </option>
										    <?php endfor;?>
											
										    
										  </select>
										<script>
										$("#choose").change(function(){
										$value=this.options[this.selectedIndex].value;
										
										$valueField=$value.split("|");
										$factoryid=$valueField[0];
										$name=$valueField[1];
										$address=$valueField[3];
										$capacity=$valueField[4];
										console.log($factoryid);
										document.getElementById("factoryid").value = $factoryid.trim();
										document.getElementById("name").value = $name.trim();
										document.getElementById("address").value = $address.trim();
										document.getElementById("capacity").value = $capacity.trim();
									});
										</script>
										</div>
									</div>
									<div class="form-group">
										<label for="DOB" class="col-md-3 control-label">Mã nhà máy</label>
										<div class="col-md-9">
											<input type="text" name="factoryid" class="form-control" id="factoryid" placeholder="Mã nhà máy">
										</div>
									</div>
									
									<div class="form-group">
										<label for="sid" class=" col-md-3 control-label">Tên đầy đủ </label>
										<div class="col-md-9">
											<input type="text" name="name" class="form-control" id="name" placeholder="Tên đầy đủ nhà máy">
										</div>
									</div>
									<div class="form-group">
										<label for="choose" class="text-align-left col-md-3 control-label">Mã ngành</label>
										<div class="col-md-9">
											<select id="choose" name="sector" class="form-control">
											<?php foreach($sector as $sector):?>
											<option><?php echo $sector['manufacturing_id']?></option>
										    <?php endforeach;?>
										  </select>
										</div>
									</div>
									<div class="form-group">
										<label for="sid" class=" col-md-3 control-label">Địa chỉ </label>
										<div class="col-md-9">
											<textarea name="address" id="address" class="form-control" placeholder="Địa chỉ"></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="sid" class=" col-md-3 control-label">Công suất nhà máy </label>
										<div class="col-md-9">
											<input type="text" name="capacity" class="form-control" id="capacity" placeholder="Công suất nhà máy">
										</div>
									</div>
									<div class="form-group">
										<label for="sid" class=" col-md-3 control-label">Thông tin khác</label>
										<div class="col-md-9">
											<textarea name="other" id="other" class="form-control" placeholder="Các thông tin khác"></textarea>
										</div>
									</div>
									  <div class="form-group">
										<div class="col-md-offset-3 col-md-10">
										  <button type="submit" class="btn btn-primary">Cập nhật</button>
										</div>
								  </div>
								</form>
			  				</div>
			  			</div>
	  				</div>
	  				<div class="col-md-6">
	  					<div class="content-box-large">
			  				<div class="panel-heading">
					            <div class="panel-title para-title">Nhập vào bằng file excel</div>
					        </div>
			  				<div class="panel-body">
							<a class="download" href="#"><i class="glyphicon glyphicon-download-alt"></i> Tải về file excel mẫu</a>
							<p class="excel-para">Nhập danh sách vào qua file excel(phiên bản Microsoft Excel 2007 là tốt nhất) theo đúng định dạng như hình sau </p>
							<img id="sample" data-toggle="modal" data-target="#myModal" src="<?php echo base_url().'assets/img/Sample.png' ?>" style="width:100%;margin-bottom:15px" alt="sample excel">
							<p>(click vào ảnh để phóng to)</p>
							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content modal-lg">
										<div class="modal-header modal-lg">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										</div>
											<div class="modal-body modal-lg">
												<img src="<?php echo base_url().'assets/img/Sample.png' ?>" style="width:100%" alt="sample excel">
												
											</div>
									</div>
								</div>
							</div>
							<div class="form-group">
							<?php echo form_open_multipart('Admin/addbrandexcel');?>
								<input type="file" class="form-control" name="userfile" />
								</div>
									<div class="form-group">
										<div class="col-md-offset-3 col-md-10">
										  <button type="submit" class="btn btn-primary">Cập nhật</button>
										</div>
								  </div>
								</form>
			  				</div>
			  			</div>
	  				</div>
	  			</div>
				<div class="row">
					<div class="col-md-12">
						<div class="content-box-large">
						<table id="table-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
							<thead>
								<tr>
								<th class="col-md-1">Mã nhà máy</th>
								<th class="col-md-4">Tên nhà máy</th>
								<th class="col-md-2">Ngành</th>
								<th class="col-md-2">Địa chỉ</th>
								<th class="col-md-1">Công suất</th>
								<th class="col-md-2">Thông tin khác</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
								<th class="col-md-1">Mã nhà máy</th>
								<th class="col-md-4">Tên nhà máy</th>
								<th class="col-md-2">Ngành</th>
								<th class="col-md-2">Địa chỉ</th>
								<th class="col-md-1">Công suất</th>
								<th class="col-md-2">Thông tin khác</th>
								</tr>
							</tfoot>
							<tbody>
							<?php foreach($factory as $factory):?>
								<tr>
								<td><?php echo $factory['factory_id']?></td>
								<td><?php echo $factory['factory_name']?></td>
								<td><?php echo $factory['sector_name']?></td>
								<td><?php echo $factory['location_code']?></td>
								<td><?php echo $factory['capacity']?></td>
								<td><?php echo $factory['other']?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>