@extends('layouts.auth') @section('content')

<div class="page-content ">

        <!-- Broadstreet: Topic Pages Leaderboard -->
        <div style="text-align:center; margin-bottom:10px;">
            <broadstreet-zone zone-id='184403'></broadstreet-zone>
        </div>

        <div class="tab-controls tab-animated tabs-large" data-tab-items="2" data-tab-active="bg-blue1-dark">

            <a href="#" {{ $activeTab === 'my' ? 'data-tab-active' : '' }} data-tab="tab-1"><i class="fas fa-user-alt"></i> My topics</a>

            <a href="#" {{ $activeTab === 'add' ? 'data-tab-active' : '' }} data-tab="tab-2"><i class="fas fa-plus-circle"></i> Add topics</a>

        </div>

        <div class="clear"></div>


        <div class="tab-content {{ $activeTab === 'my' ? 'tab-active' : '' }}" id="tab-1">

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

            <!-- Broadstreet: Topic Pages Square -->
            <div style="text-align:center; margin: 10px 0;">
                <broadstreet-zone zone-id='184404'></broadstreet-zone>
            </div>

            <br>

        </div>

        <!-- Broadstreet: Topic Pages Interior Banner -->
        <div style="text-align:center; margin: 10px 0;">
            <broadstreet-zone zone-id='184406'></broadstreet-zone>
        </div>

        <div class="tab-content {{ $activeTab === 'add' ? 'tab-active' : '' }}" id="tab-2">

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

            <!-- Broadstreet: Topic Pages Skyscraper -->
            <div style="text-align:center; margin-top:10px;">
                <broadstreet-zone zone-id='184405'></broadstreet-zone>
            </div>

        </div>



</div>

@endsection
