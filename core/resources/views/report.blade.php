@extends('layouts.user')

@section('content')
    <div class="col-md-12 single" id="comments">
        <h2 class="text-center">Report</h2>
        <form method="post">
            @csrf
            <input type="hidden" name="report_post" value="{{ $post->id }}">
            <div class="form-group">
                <label for="" class="control-label">Reason</label>
                <textarea name="report_content" class="form-control" autofocus></textarea>
            </div>
            <input class="btn btn-lg btn-primary" type="submit" value="Submit For Review">
        </form>
        <!-- .section-box -->
    </div>
@endsection