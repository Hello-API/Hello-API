{{--
    This partial renders the Error Messages from controllers or services.
--}}
        
@if (\Session::has('error') && !empty(\Session::get('error')))
    <div class="alert alert-danger alert-dismissible margin-top-10" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Error!!</strong><br>
        
        @if(is_array(session('error')))
        
            @foreach(\Session::get('error') as $error)
                <div>
                {{ $error }}
                </div>
            @endforeach
            
        @else
            <div>
                {{ session('error') }}
            </div>
        @endif
        
    </div>
@endif