@extends('layouts.app')

@section('content')
<style>
.error{
  color:red;
}
</style>
@if ($message = Session::get('error'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{{ $message }}</strong>
    </div>
    <br>
    @endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                  <form action="{{route('update_product')}}" method="post" id="editproduct" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$id}}" name="product_id" id="product_id">
            <div class="form-group">
            <label>Product Name <sup>(*)</sup></label>
            <input class="form-control" type="text" name="name" value="{{$products->name}}" id="name"/>
            </div>

        <div class="form-group">
        <label>Product Price <sup>(*)</sup></label>
        <input class="form-control numeric_only" type="text" name="price" value="{{$products->price}}" id="price"/>
        </div>

        <div class="form-group">
        <label>Product Color</label>
        <select class="form-control" name="colors[]" id="colors" multiple>

        </select>
        </div>

        <div class="form-group">
        <label>Product Size</label>
        <select class="form-control" name="sizes[]" id="sizes" multiple>
        </select>
        </div>

        <div class="form-group">
        <label>Product Images</label>
        <input type="file" name="filename[]" class="form-control" multiple accept="image/*,.jpg,.gif,.png,.jpeg" >
        </div>
        @foreach($products->image as $image)
          <img src="{{asset('Uploads/'.@$image->pic)}}" style="width: 62px;" class="id{{@$image->id}}"><span class="id{{@$image->id}}" onClick="delimage({{@$image->id}})">X</span>
        @endforeach

        <div class="modal-footer mt-4 mb-4 border-top-0  justify-content-center">
        <input type="submit" class="btn btnOne" style="min-width:160px;" id="clientLogin1" value="Edit Product">
      </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>

if ($("#editproduct").length > 0) {
    $("#editproduct").validate({

    rules: {
      name: {
        required: true,
        maxlength: 50
      },

       price: {
            required: true,
            digits:true,
        },
        'filename[]':{
                    accept:"jpg,png,jpeg,gif"
                }
    },
    messages: {

      name: {
        required: "Please enter Product Name",
        maxlength: "Your product name maxlength should be 50 characters long."
      },
      price: {
        required: "Please enter Product Price",
        digits: "Please enter only numbers",
      },
      'filename[]':{
                    accept: "Only image type jpg/png/jpeg/gif is allowed"
                },


    },
    })
  }
var product_id=$("#product_id").val();
var color_select2 = null;
var size_select2 = null;
  $.ajax({
          url: '{{route("get_product_data")}}',
          type: 'POST',
          data: {
              id:product_id,
              _token: '{{ csrf_token() }}',
          },
          dataType: 'JSON',
          success: function (data) {

              if(color_select2)
                  $('#colors').empty();
              color_select2 = $("#colors").select2({
                  placeholder: 'Select Color',
                  data: data.colors
              });

              if(size_select2)
                    $('#sizes').empty();
                size_select2 = $("#sizes").select2({
                    placeholder: 'Select Size',
                    data: data.size,
                });
          }
      });

      function delimage($id){
        var id=$id;
        $.ajax({
                url: '{{route("del_product_image")}}',
                type: 'POST',
                data: {
                    id:id,
                    _token: '{{ csrf_token() }}',
                },
                dataType: 'JSON',
                success: function (data) {
                  alert('Deleted Succesfully');
                   $( ".id"+id ).remove();
                }
                });
      }

      $(".numeric_only").keypress(function (e) {
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
        return false;
      }
    }); 
</script>
@endsection
