@extends('admin.layout.master')

@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> Membership Plans </h3>
            <hr>
            @if(count($plans))
                @foreach($plans->chunk(3) as $p)
                    <div class="row">
                        @foreach($p as $plan)
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">{{ $plan->name }}</div>
                                    <div class="panel-body">
                                        <ul style="font-size: 15px;" class="list-group text-center bold">
                                            <li class="list-group-item">Price - {{ $plan->price }} {{ $gnl->currency }}</li>
                                            <li class="list-group-item">Write Post - {{ $plan->write_payment }} ({{ $plan->write_compound }} {{ ($plan->write_max == -1)?' Unlimited':$plan->write_max }}) </li>
                                            <li class="list-group-item">Read Post - {{ $plan->read_payment }} ({{ $plan->read_compound }} {{ ($plan->read_max == -1)?' Unlimited':$plan->read_max }}) </li>
                                            <li class="list-group-item">Post View - {{ $plan->view_payment }} ({{ $plan->view_compound }} {{ ($plan->view_max == -1)?' Unlimited':$plan->view_max }})</li>
                                            <li class="list-group-item">Like Post - {{ $plan->like_payment }} ({{ $plan->like_compound }} {{ ($plan->like_max == -1)?' Unlimited':$plan->like_max }})</li>
                                            <li class="list-group-item">Comment Post - {{ $plan->comment_payment }} ({{ $plan->comment_compound }} {{ ($plan->comment_max == -1)?' Unlimited':$plan->comment_max }})</li>
                                            <li class="list-group-item">Timeline Share - {{ $plan->timeline_share_payment }} ({{ $plan->timeline_share_compound }} {{ ($plan->timeline_share_max == -1)?' Unlimited':$plan->timeline_share_max }})</li>
                                            <li class="list-group-item">Social Share - {{ $plan->social_share_payment }} ({{ $plan->social_share_compound }} {{ ($plan->social_share_max == -1)?' Unlimited':$plan->social_share_max }})</li>
                                        </ul>
                                    </div>
                                    <div class="panel-footer">
                                        <a class="btn btn-success btn-block" href="{{ route('admin.plan.edit', $plan->id) }}">Edit</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <br><br>
                @endforeach
            @endif
        </div>
    </div>
@endsection