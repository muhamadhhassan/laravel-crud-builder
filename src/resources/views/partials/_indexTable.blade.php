<table class="datatable datatable-bordered datatable-head-custom" id="kt_datatable">
  <thead>
    <tr>
      @foreach($data['columns'] as $column)
        <th>{{ ucwords($column->label) }}</th>
      @endforeach
      @if ($data['canEdit'] || $data['canDelete'])   
        <th>Actions</th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($collection as $item)    
      <tr>
        @for ($i = 0; $i < count($data['columns']); $i++)
          <td>
            @if ($data['columns'][$i]->isEscaped)
              {!! $data['columns'][$i]->getValue($item) !!}
            @else
              {{ ucwords($data['columns'][$i]->getValue($item)) }}
            @endif
          </td>
        @endfor
        <td nowrap="nowrap" style="">
          @if ($data['canEdit'])
            <a href="{{ $data['resourceRoute']. '/' .$item->id }}/edit" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
          @endif
          @if ($data['canDelete'])
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
                    @php
                      $label = $data['recognizedBy'];
                    @endphp
                    Are you sure you want to remove <b>{{ $item->$label }}</b>?
                  </div>
                  <div class="modal-footer">
                    <form action="{{ $data['resourceRoute'] . '/' . $item->id}}" method="POST">
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
      </tr>
    @endforeach
  </tbody>
</table>