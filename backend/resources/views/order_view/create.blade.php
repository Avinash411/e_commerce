@extends('layouts.app')
@section('content')

<div class="container">
      <div class="card-deck mb-3 text-center">
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Pending</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">@php echo count($arr); @endphp <small class="text-muted">/ request</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li></li>
              <li></li>
              <li></li>
              <li></li>
            </ul>
            {{--<button type="button" class="btn btn-lg btn-block btn-outline-primary">Sign up for free</button>--}}
          </div>
        </div>
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Approved</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">$15 <small class="text-muted">/ mo</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>20 users included</li>
              <li>10 GB of storage</li>
              <li>Priority email support</li>
              <li>Help center access</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-primary">Get started</button>
          </div>
        </div>
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Dispatch</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">$29 <small class="text-muted">/ mo</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>30 users included</li>
              <li>15 GB of storage</li>
              <li>Phone and email support</li>
              <li>Help center access</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-primary">Contact us</button>
          </div>
        </div>
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Cancel</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">$29 <small class="text-muted">/ mo</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>30 users included</li>
              <li>15 GB of storage</li>
              <li>Phone and email support</li>
              <li>Help center access</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-primary">Contact us</button>
          </div>
        </div>
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Return</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">$29 <small class="text-muted">/ mo</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>30 users included</li>
              <li>15 GB of storage</li>
              <li>Phone and email support</li>
              <li>Help center access</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-primary">Contact us</button>
          </div>
        </div>
      </div>
</div>
<div class="container" style="width: 100%;">
	<table class="table">
		<tr>
			<th>Product Name</th>
			<th>Variant</th>
			<th>Price</th>
			<th>User Name</th>
			<th>Order id</th>
			<th>Action</th>
		</tr>
	</table>
		<label>Pending Information</label>
		<table class="table">
		@foreach($arr as $a)
		<tr>
			<td>{{$a['product']}}</td>
			<td>{{$a['variant']}}</td>
			<td>{{$a['price']}}</td>
			<td>{{$a['user']}}</td>
			<td>{{$a['order_id']}}</td>
			<td><select class="form-control">
				
				<option>Approved</option>
				<option>Dispatch</option>
				<option>Cancel</option>
				
			</select></td>
		</tr>

		@endforeach
	</table>
	<table class="table">
<label>Approved Information</label>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<table class="table">
		<label>Dispatch Information</label>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<table class="table">
		<label>Cancel Information</label>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<table class="table">
		<label>Return Information</label>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

	</table>
</div>
@endsection