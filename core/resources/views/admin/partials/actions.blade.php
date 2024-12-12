<a target="_blank" href="/post/{{ $post->id }}" class="btn btn-primary" data-toggle="tooltip" title="View">
 <i class="fa fa-eye"></i>
</a>
@if ($post->pinned)
 <button class="btn btn-warning unpin" data-id="{{ $post->id }}" data-toggle="tooltip" title="Unpin">
     <i class="fa fa-thumb-tack"></i>
 </button>
@else
 <button class="btn btn-success pin" data-id="{{ $post->id }}" data-toggle="tooltip" title="Pin">
     <i class="fa fa-thumb-tack"></i>
 </button>
@endif
<button class="btn btn-danger delete" data-id="{{ $post->id }}" data-toggle="tooltip" title="Delete">
 <i class="fa fa-trash"></i>
</button>