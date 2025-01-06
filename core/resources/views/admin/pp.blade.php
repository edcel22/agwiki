@extends('admin.layout.master')

@section('body')



    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$data['page_title']}} </h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-envelope font-blue-sharp"></i>
                                <span class="caption-subject font-blue-sharp bold uppercase">{{$data['page_title']}}</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-body">
                                    <div class="form-group">
                                        <textarea class="form-control" name="pp" rows="10">{!! $gnl->pp !!}</textarea>
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




    <script src="https://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

@endsection