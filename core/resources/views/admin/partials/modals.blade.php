<div class="modal fade" id="delete">
 <div class="modal-dialog">
     <div class="modal-content">

         <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             <h4 class="modal-title"></i> <strong>Delete Post</strong> </h4>
         </div>
         <form method="POST" action="{{ route('admin.post.delete') }}" accept-charset="UTF-8">
             {{ csrf_field() }}
             <input type="hidden" name="id" id="delete-id">
             <div class="modal-body">
                 <h3 class="text-center text-danger">Are You Sure To Delete This Post?</h3>
             </div>
             <div class="modal-footer">
                 <div class="row">
                     <div class="col-md-6">
                         <button data-dismiss="modal" class="btn btn-default btn-block"> Cancel</button>
                     </div>
                     <div class="col-md-6">
                         <button type="submit" class="btn btn-danger btn-block"> Delete</button>
                     </div>
                 </div>
             </div>
         </form>
     </div>
 </div>
</div>