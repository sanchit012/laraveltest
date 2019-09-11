@extends('layouts.app')

@section('content')
<style>
.error{
  color:red;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                  <form action="{{route('add_product')}}" method="post" id="addproduct" enctype="multipart/form-data">
                    @csrf
            <div class="form-group">
            <label>Product Name <sup>(*)</sup></label>
            <input class="form-control" type="text" name="name" value="{{old('name')}}" id="name"/>
            </div>

        <div class="form-group">
        <label>Product Price <sup>(*)</sup></label>
        <input class="form-control numeric_only" type="text" name="price" value="{{old('price')}}" id="price"/>
        </div>

        <div class="form-group">
        <label>Product Color</label>
        <select class="form-control multi-select" name="colors[]" id="color" multiple>
          @foreach($allcolors as $allcolor)
          <option value="{{@$allcolor->id}}">{{@$allcolor->name}}</option>
          @endforeach
        </select>
        </div>

        <div class="form-group">
        <label>Product Size</label>
        <select class="form-control multi-select" name="sizes[]" id="sizes" multiple>
          @foreach($allsizes as $allsize)
          <option value="{{@$allsize->id}}">{{@$allsize->name}}</option>
          @endforeach
        </select>
        </div>

        <div class="form-group">
        <label>Product Images</label>
        <input type="file" name="filename[]" class="form-control" multiple accept="image/*,.jpg,.gif,.png,.jpeg" >
        </div>

        <div class="modal-footer mt-4 mb-4 border-top-0  justify-content-center">
        <input type="submit" class="btn btnOne" style="min-width:160px;" id="clientLogin1" value="Add Product">
      </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
$(".multi-select").chosen({
  no_results_text: "Oops, nothing found!"
});
if ($("#addproduct").length > 0) {
    $("#addproduct").validate({

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

  $(".numeric_only").keypress(function (e) {
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    $("#errmsg").html("Digits Only").show().fadeOut("slow");
    return false;
  }
});
</script>
@endsection
