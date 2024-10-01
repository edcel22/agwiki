@extends('layouts.auth') @section('content')

<div class="page-content ">


        <div class="tab-controls tab-animated tabs-large" data-tab-items="2" data-tab-active="bg-blue1-dark">

            <a href="#" data-tab-active data-tab="tab-1"><i class="fas fa-user-alt"></i> My topics</a>

            <a href="#" data-tab="tab-2"><i class="fas fa-plus-circle"></i> Add topics</a>

        </div>

        <div class="clear"></div>


        <div class="tab-content" id="tab-1">

            <h4>TOPICS (click a topic to remove it)</h4> @if($interests && count($interests))

            <div id="activeTopicList">

                @foreach($interests as $topic)

                <div class="topic active post-action remtopic" data-post="{{$topic->id}}" href="#"><i class="fas fa-minus-circle"></i> {{ $topic->name }}</div>

                @endforeach

            </div>

            @else

            <li>

                <div class="single-notification-items">

                    <h4 class="not-found">No topic Found</h4>

                </div>

            </li>

            @endif

            <div class="clear"></div>

            <br>

            <br>

            <br>

        </div>

        <div class="tab-content" id="tab-2">

            <div class="search-box search-color shadow-tiny round-large bottom-20">

                <i class="fa fa-search"></i>

                <input type="text" placeholder="Search for topics... " data-search="">

            </div>

            <div class="search-results search-list">

                <div class="link-list link-list-1 link-list-long-border topics">

                    @foreach($alltopics as $topic)

                    <!--<a href="" class="topic inactive post-action topic" data-post="{{$topic->id}}"><i   class="fas fa-plus-circle "></i> {{ $topic->name }}</a>-->

                    <div data-post="{{$topic->id}}" data-filter-item="{{$topic->id}}" data-filter-name="{{ strtolower($topic->name) }}" class="topiclist ">

                        <span ><i class="fas fa-plus-circle"></i> {{ $topic->name }}</span>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>



</div>

@endsection
