
@extends('admin.layout.master')

@section('body')
    
        
 
<div class="page-content-wrapper">
<div class="page-content">

<h3 class="page-title uppercase bold"> {{$data['page_title']}} </h3>
<hr>


<div class="row">
	<div class="col-md-8 col-md-offset-2">


        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase">General Settings</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form role="form" method="POST" action="{{ route('admin.UpdateGenSetting') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Website Title</h4>
                                    <input type="text" class="form-control input-lg" value="{{ $gnl->title }}" name="title" >
                                </div>
                                <div class="col-md-6">
                                    <h4>Youtube Video ID (EX: xy52wA9J4-A)</h4>
                                    <input type="text" class="form-control input-lg" value="{{ $gnl->vid }}" name="vid">
                                </div>
                            </div>
                            <hr>
                            <div class="row">

                                <div class="col-md-6">
                                    <h4>EMAIL VERIFICATION</h4>
                                    <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100%" type="checkbox" value="1" name="emailver" {{ $gnl->emailver == "0" ? 'checked' : '' }}>
                                </div>
                                <div class="col-md-6">
                                    <h4>SMS VERIFICATION</h4>
                                    <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100%" type="checkbox" value="1" name="smsver"  {{ $gnl->smsver == "0" ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="row">
                                <hr/>
                                <div class="col-md-6">
                                    <h4>EMAIL NOTIFICATION</h4>
                                    <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100%" type="checkbox" value="1" name="emailnotf"  {{ $gnl->emailnotf == "1" ? 'checked' : '' }}>
                                </div>
                                <div class="col-md-6">
                                    <h4>SMS NOTIFICATION</h4>
                                    <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100%" type="checkbox" value="1" name="smsnotf" {{ $gnl->smsnotf == "1" ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="row">
                                <hr/>
                                <div class="col-md-6 col-md-offset-3">
                                    <button class="btn blue btn-block btn-lg">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



</div>
</div>



              
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
  //<![CDATA[
  bkLib.onDomLoaded(function() {
    elementArray = document.getElementsByClassName("nice-edit");
    for (var i = 0; i < elementArray.length; ++i) {
      nicEditors.editors.push(
        new nicEditor().panelInstance(
          elementArray[i]
        )
      );
    }
  });
  //]]>
</script>
						
                    
@endsection