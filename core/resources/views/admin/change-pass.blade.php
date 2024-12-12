@extends('admin.layout.master')

@section('body')



<div class="page-content-wrapper">
<div class="page-content">

<h3 class="page-title uppercase bold"> {{$data['page_title']}} </h3>
<hr>
<div class="row">

	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-key font-blue-sharp"></i>
						<span class="caption-subject font-blue-sharp bold uppercase">Change Password</span>
					</div>
				</div>
				<div class="portlet-body form">
					<form role="form" method="POST" action="">
						{{ csrf_field() }}
						<div class="form-body">
							<div class="form-group">
								<label>Old Password</label>
								<input type="password" name="old" class="form-control input-lg" required>
							</div>
							<div class="form-group">
								<label><br>New Password</label>
								<input type="password" name="password" class="form-control input-lg" required>
							</div>
							<div class="form-group">
								<label>Confirm Password</label>
								<input type="password" name="password_confirmation" class="form-control input-lg" required>
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn green btn-block btn-lg">Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>



</div>
</div>

@endsection
