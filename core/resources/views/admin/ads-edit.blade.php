@extends('admin.layout.master')

@section('body') 

    <div class="single page-content page-content-wrapper">
    <div class="page-content">
        <h4 class="text-center">Edit Ad</h4>

        <form method="post" action="{{ route('admin.ads.store') }}" enctype="multipart/form-data">

            @csrf
            <input type="hidden" name="id" value="{{$ads->id}}">

           
            
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="name" class="control-label">Image*</label>
                        <input type="text" value="{{$ads->image}}" id="image" name="image" class="form-control input-style-1" required>
                    </div>
                    
           		</div>
                <div class="col-md-4">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="name" class="control-label">Link*</label>
                        <input type="text" value="{{$ads->link}}" id="link" name="link" class="form-control input-style-1" required>
                    </div>
                    
           		</div>
                <div class="col-md-4">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="name" class="control-label">Content*</label>
                        <input type="text" value="{{$ads->content}}" id="content" name="content" class="form-control input-style-1" required>
                    </div>
                    
           		</div>
            </div>
			
			 <div class="row">
                <div class="col-md-12">
                    <span>Topics: </span>
                    
                    <div class="col-md-12" >
                        
                        <div class="form-group form-check crossposting-input input-style-1">
                            @foreach($interest as $int)
                                <div class="col-md-6">
                                <label style="width:50%; float:left" for="interest{{$int->id}}">{{$int->name}}</label>
                                <input style="width:50%; float:left"  type="checkbox" class="form-control input-style-1" name="interest[]" id="interest{{$int->id}}" value="{{$int->id}}" {{ ((in_array($int->id,$rss_interest))?"checked":"") }} > 
                                </div>
                            @endforeach
                        </div>
                        </div>
                    
                </div>

            <br>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-success btn-block button button-full button-s shadow-large button-round-small bg-green1-dark top-10" type="submit">Save Ad</button>
                </div>
            </div>
            <br><br>

        </form>
    
    
    
</div>
</div>
@endsection

