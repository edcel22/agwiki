@extends('admin.layout.master')

@section('body')

    <div class="single page-content page-content-wrapper">
    <div class="page-content">
        <h4 class="text-center">New Topic</h4>

        <form method="post" action="{{ route('admin.topic.store') }}" enctype="multipart/form-data">

            @csrf

                       
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="name" class="control-label">Name*</label>
                        <input type="text" id="name" name="name" class="form-control input-style-1" required>
                    </div>
                    
           		</div>
                
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-success btn-block button button-full button-s shadow-large button-round-small bg-green1-dark top-10" type="submit">Save Topic</button>
                </div>
            </div>
            <br><br>

        </form>
    
    
    
</div>
</div>
@endsection

