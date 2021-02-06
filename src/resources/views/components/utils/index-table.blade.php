<div class="table-responsive">
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        @foreach($columns as $column)
          <th>{{ ucwords($column->label) }}</th>
        @endforeach
        @if ($editable || $deletable)   
          <th>Actions</th>
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach ($records as $item)    
        <tr>
          @for ($i = 0; $i < count($columns); $i++)
            <td>
              @if ($columns[$i]->isEscaped)
                {!! $columns[$i]->getValue($item) !!}
              @else
                {{ ucwords($columns[$i]->getValue($item)) }}
              @endif
            </td>
          @endfor
          @if($editable || $deletable)
            <td nowrap="nowrap" style="">
              @if ($editable)
                <a href="{{ $route. '/' .$item->id }}/edit" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
              @endif
              @if ($deletable)
                <button class="btn btn-sm btn-clean btn-icon" title="Delete" data-toggle="modal" data-target="#delete-{{ $item->id }}"><i class="la la-trash"></i></button>
                <!-- Modal-->
                <div class="modal fade" id="delete-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to remove <b>{{ $item->$labeledBy }}</b>?
                      </div>
                      <div class="modal-footer">
                        <form action="{{ $route . '/' . $item->id}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-danger font-weight-bold">Delete</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            </td> 
          @endif
        </tr>
      @endforeach
    </tbody>
  </table>
  {!! $records->links() !!}
</div>