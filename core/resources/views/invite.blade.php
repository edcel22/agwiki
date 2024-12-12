@extends('layouts.auth')

@section('css')

@endsection

@section('content')
<div class="page-content ">
    <div class="clearfix"></div>
    <h1 class="text-center">Invite Friend</h1>
    <div class="post-loop-wrapper">
        <form action="{{ route('user.invite.email') }}" method="post">
            @csrf
            <div class="col-md-12">
                <div class="form-group crossposting-input">
                    <label for="to" class="control-label">To</label>
                    <input name="to" type="email" required id="to" class="form-control" placeholder="friend@friends.com">
                </div>
                <div class="form-group crossposting-input">
                    <label for="message" class="control-label">Message</label>
                    <textarea style="width:75%; min-height:300px" name="message" id="message" class="form-control" required>
						
{{Auth::user()->name}} has invited you to join AgWiki, a food and agricultural social site focused on bringing together the global food community in order to share information and create valuable relationships.

On behalf of the AgWiki team, we would also like to encourage your participation so you can be part of this new and growing local, regional, and global platform. 

Please register at http://agwiki.com/
Our mission is to Solve World Food Problems Socially. 

Thank you,
Team AgWiki

                    
                    
                    </textarea>
                </div>
                <div class="form-group crossposting-input">
                    <input type="submit" value="Send" class="btn btn-success button button-m button-round-small bg-blue1-dark shadow-small">
                </div>
            </div>
        </form>
        <!--<h3 class="text-center">Invite Via Social Media</h3>
        <div class="addthis_inline_share_toolbox_aiyw" style="text-align: center;" data-url="{{ route('profile', Auth::user()->username) }}" data-title="Invitation to join AgWiki" data-description="Invitation to join AgWiki"></div>-->
    </div>
</div>
@endsection

@section('js')
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5b028cce69cdbe02"></script>
@endsection
