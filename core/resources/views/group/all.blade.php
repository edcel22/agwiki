@extends('layouts.auth') @section('css')

<style>
    .notification-area-start ul.pagination {
        display: block !important;
    }
</style>

@endsection @section('content')

<div class="page-content ">

    <div class="row" style="padding-bottom:25px">

        <div class="col-md-12">

            @if (Auth::check())
                <button onClick="document.location='{{ route('user.group.new') }}'" class="btn btn-lg btn-success btn-block button button-full button-s shadow-large button-round-small bg-green1-dark top-10" style="width:100%"><i class="fas fa-plus-circle"></i> Create a Group</button>
            @endif

            <form id="logout-form" action="/logout" method="POST" style="display: none;">

                @csrf </form>

        </div>

    </div>

    @if (Auth::check())
    <div class="tab-controls tab-animated tabs-large" data-tab-items="2" data-tab-active="bg-blue1-dark">

        <a href="#" data-tab-active data-tab="tab-1"><i class="fas fa-user-alt"></i> My Groups</a>

        <a href="#" data-tab="tab-2"><i class="fas fa-search"></i> Search for Groups</a>

    </div>
    @else
    <div class="tab-controls tab-animated tabs-large" data-tab-items="2" data-tab-active="bg-blue1-dark">

        <a href="#" data-tab-active data-tab="tab-2"><i class="fas fa-search"></i> Search for Groups</a>

    </div>
    @endif

    <div class="clear"></div>

    <!-- My Groups tab content start -->
    @if(Auth::check())
    <div class="tab-content" id="tab-1">

        @if(isset($groups) && count($groups)) 
            @foreach($groups as $group) 
                @if(isset($group->group) && $group->group)
                <div class="content content-box" style="border-bottom:1px solid #CCC;margin-bottom:0">

                    <a href="{{ route('user.groups', optional($group->group)->slug ?? '#') }}">

                        <h3 class="top-10">{{ optional($group->group)->name ?? 'Unnamed Group' }}</h3>

                        <p class="description bottom-10">
                            {{ optional($group->group)->description ?? 'No description available' }}
                        </p>

                    </a>

                    <p>
                        @if(isset($group->group) && method_exists($group->group, 'creator') && $group->group->creator())
                            <a href="{{ route('profile', optional($group->group->creator())->username ?? '#') }}">
                                <span><i class="fas fa-user-alt"></i>{{ optional($group->group->creator())->name ?? 'Unknown Creator' }}</span>
                            </a>
                        @else
                            <span><i class="fas fa-user-alt"></i>Unknown Creator</span>
                        @endif

                        <span><i class="fas fa-user-check"></i>{{ number_format_short(optional($group->group)->memberCount() ?? 0) }} Members</span>

                        <span><i class="far fa-file-alt"></i>
                            @if(isset($group->group->topics) && count($group->group->topics))
                                @foreach($group->group->topics as $myinterest)
                                    <a href="#">{{ $myinterest->name ?? 'Unknown Topic' }}</a>,
                                @endforeach
                            @else
                                No topics
                            @endif
                        </span>
                    </p>

                    <p>
                        <br>
                        <a href="{{ route('user.groups', optional($group->group)->slug ?? '#') }}" class="button button-xs bg-highlight bg-blue1-light"><i class="fas fa-arrow-alt-circle-right"></i> Visit Group</a>
                        <!--<a href="#" class="button button-xs bg-highlight bg-red2-light"><i class="fas fa-times-circle"></i></a>-->
                    </p>

                </div>
                @endif 
            @endforeach 
        @else
            <div class="single-notification-items">
                <h4 class="not-found">No Group Found</h4>
            </div>
        @endif

        <div class="clear"></div>
        <br>
        <br>
        <br>
    </div>
    @endif
    <!-- My Groups tab content end -->

    <div class="tab-content" id="tab-2">

        <div class="search-box search-color shadow-tiny round-large bottom-20">
            <i class="fa fa-search"></i>
            <input type="text" placeholder="Search for groups... " data-search="">
        </div>

        <div class="search-results search-list">
            <div class="link-list link-list-2 link-list-long-border">
                @if(isset($allGroups) && count($allGroups)) 
                    @foreach($allGroups as $agroup)
                        @if(isset($agroup))
                            @if (Auth::check())
                                <a href="{{ route('user.groups', $agroup->slug ?? '#') }}" data-filter-item="{{$agroup->id}}" data-filter-name="{{strtolower($agroup->name ?? '')}}  @if(isset($agroup->topics) && count($agroup->topics))@foreach($agroup->topics as $groupTopic){{strtolower($groupTopic->name ?? '')}} @endforeach @endif" class="grouplist">
                                    <span>{{$agroup->name ?? 'Unnamed Group'}}</span>
                                    <strong></strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            @else 
                                <a data-filter-item="{{$agroup->id}}" data-filter-name="{{strtolower($agroup->name ?? '')}}  @if(isset($agroup->topics) && count($agroup->topics))@foreach($agroup->topics as $groupTopic){{strtolower($groupTopic->name ?? '')}} @endforeach @endif" class="grouplist">
                                    <span style = "cursor: default;">{{$agroup->name ?? 'Unnamed Group'}}</span>
                                    <strong></strong>
                                </a>
                            @endif
                        @endif
                    @endforeach 
                @endif
            </div>
        </div>
    </div>

</div>

@if(Auth::check() && isset($groups))
    {{ $groups->links() }} 
@endif 

@endsection