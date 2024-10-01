<script type='text/javascript'>

function registerPopup()
{

    const el = document.createElement('div')
    el.innerHTML = "<a href='/login'>Please use this link to sign up</a>"

    swal({
        title: "This feature is only for members of AgWiki", 
        content: el,
 
});
}

</script>