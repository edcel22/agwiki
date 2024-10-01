@extends('layouts.dash')
@section('content')
<div class="nav nav-medium">
    <a id="page-home" href="https://go.agwiki.com/">
        <i class="fas fa-globe-africa color-green1-dark"></i><span>About AgWiki</span><i class="fa fa-angle-right"></i>
    </a>
    <!-- <a id="page-components" href="https://go.agwiki.com/team">
        <i class="fas fa-users color-blue2-dark"></i><span>AgWiki Team</span><i class="fa fa-angle-right"></i>
    </a>
    <br>
	<div class="divider"></div>
    <a id="page-menus" href="https://go.agwiki.com/media">
        <i class="fab fa-youtube color-red1-dark"></i><span>Media</span><i class="fa fa-angle-right"></i>
    </a>
    <a id="page-site-pages" href="https://go.agwiki.com/sponsor">
        <i class="fas fa-file-invoice-dollar color-mint-dark"></i><span>Advertise</span><i class="fa fa-angle-right"></i>
    </a>
    <a id="page-pageapps" href="https://go.agwiki.com/partners">
        <i class="far fa-handshake color-dark1-dark"></i><span>Partners</span><i class="fa fa-angle-right"></i>
    </a> -->
    <a id="page-contact" href="https://go.agwiki.com/contact">
        <i class="fa fa-envelope color-blue2-dark"></i><span>Contact</span><i class="fa fa-angle-right"></i>
    </a>

    <div class="divider top-15"></div>
    <p>Copyright <span class="copyright-year"></span> - AgWiki <?php echo date('Y'); ?>. All rights Reserved.</p>
</div>
@endsection
