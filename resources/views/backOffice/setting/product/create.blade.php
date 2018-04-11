@extends('layouts.backOffice.template')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/back-office/setting/product/create.css')}}"/>
@endsection

@section('module_name', 'PRODUCTS')
@section('page_name', 'CREATE')

@section('body')
<section class="x_content scroll-2">
  <section class="product--create">
    <form action="{{ route('backOffice.setting.product.store') }}"  method="POST" enctype="multipart/form-data">
      {!! csrf_field() !!}
      <div class="product--create--header">
        <div class="row">
          <div class="col-md-2" style="overflow: hidden">
            <div class="form-group">
              <div class="upload-preview">
                <input type="file" name="imageProduct" accept="image/gif, image/jpeg, image/png">
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="form-group">
              <label for="product-name" class="text-black">PRODUCT NAME</label>
              <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
            </div>
            <div class="form-group">
              <label for="product-description" class="text-black">PRODUCT DESCRIPTION</label>
              <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="spacer"></div>
      <div class="product--create--detail">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="genre" class="text-black">GENRE</label>
              <select id="genre" name="genre" class="form-control">
                @foreach($generals as $row => $general)
                <option value="{{ $general->id }}" @if(old('genre') == $general->id) selected="selected" @endif>{{ $general->company_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <label for="rating" class="text-black">RATING</label>
            <input type="text" name="rating" class="form-control" value="{{ old('rating') }}" />
          </div>
          <div class="col-md-4">
            <label for="number_of_player" class="text-black">NUMBER OF PLAYER</label>
            <input type="text" name="number_of_player" class="form-control" value="{{ old('number_of_player') }}" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="genre" class="text-black">PUBLISHER</label>
              <select name="publisher_id" id="publisher" class="form-control">
                @foreach($publishers as $row => $publisher)
                <option value="{{ $publisher->id }}" @if(old('publisher_id') == $publisher->id) selected="selected" @endif>{{ $publisher->name }}</option>
                @endforeach
              </select>
          </div>
        </div>
      </div>
      <table class="table ngin-table mt-2">
        <thead>
          <tr><th class="text-left" colspan="3">PLATFORM</th></tr>
        </thead>
        <tbody>
          <?php $i = 1; ?> 
          @foreach($platforms as $row => $platform)
          {{-- Becareful this is 1-indexed loop --}}
          @if($i%3 == 1) <tr> @endif
            <td class="text-left">
              <input id="platforms[{{ $platform->id }}]" name="platforms[]" value="{{ $platform->id }}" type="checkbox" class="iCheck"/>
              <label for="platforms[{{ $platform->id }}]" class="iCheck-label">{!! $platform->name !!}</label>
            </td>
          @if($i%3 == 0) </tr> @endif
          <?php $i++; ?> 
          @endforeach
        </tbody>
      </table>
      <table class="table ngin-table mt-2">
        <thead>
          <tr><th class="text-left" colspan="3">EDITION</th></tr>
        </thead>
        <tbody>
          <?php $i = 1; ?> 
          @foreach($editions as $row => $edition)
          @if($i%3 == 1) <tr> @endif
            <td class="text-left">
              <input id="edition[{{ $edition->id }}]" name="edition[]" value="{{ $edition->id }}" type="checkbox" class="iCheck" @if(strtolower($edition->name) === 'standard') checked="checked" @endif/>
              <label for="edition[{{ $edition->id }}]" class="iCheck-label">{!! $edition->name !!}</label>
            </td>
          @if($i%3 == 0) </tr> @endif
          <?php $i++; ?>
          @endforeach
          <tr>
            <td colspan="3" class="text-left">
              <div class="col-md-3">
                <input type="text" class="form-control" name="new_edition" placeholder="Add more" value="{{ old('new_edition')}}">
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="button-actions">
        <button type="submit" class="btn btn-ngin btn-default">
          <span class="btn-label"><i class="fa fa-floppy-o success" aria-hidden="true"></i></span>SAVE
        </button>
        <button type="reset" class="btn btn-ngin btn-default">
          <span class="btn-label"><i class="fa fa-times-circle-o danger" aria-hidden="true"></i></span>CANCEL
        </button>    
      </div>
    </form>
  </section>
</section>
@endsection

@section('script')
<script src="{{ asset('js/back-office/templates/upload-preview/upload-preview.js') }}"></script>
<script src="{{ asset('js/back-office/setting/product/create.js') }}"></script>
<script>
(function ( $ ) {
  @if(session()->has('success'))
    toastr["success"]("{{ session()->get('success') }}", "Success");
  @elseif(session()->has('failure'))
    toastr["warning"]("{{ session()->get('failure') }}", "Warning");
  @endif

    @if ($errors->any())
      @foreach ($errors->all() as $error)
        toastr["error"]("{{ $error }}", "Error");
      @endforeach
    @endif
}( jQuery ));
</script>
@endsection