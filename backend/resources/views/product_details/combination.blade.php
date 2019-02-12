
@php $rnd = 0;

@endphp

@while(1)
		
		<div id="{{$rnd}}">
<div class="card-header text-center">{{ __('Created Combination') }}</div>
		@for($i=0;$i<$n;$i++)

		
<input type="text" name="gg[{{$rnd}}][attr][][{{explode('_',$final[$i][$temp[$i]])[0]}}]" value="{{explode('_',$final[$i][$temp[$i]])[1]}}" readonly class="form-control" class="">
            
		@endfor

<button type="button" class="del btn btn-danger" data-id={{$rnd}}>Remove Variant</button>	<br>
<br>Image:<input type="File" name="gg[{{$rnd}}][file][]" multiple="multiple"><br>
     <br>Price:<input type="number" name="gg[{{$rnd}}][price]" class="form-control"><br>
     SKU:<input type="text" name="gg[{{$rnd}}][sku]" class="form-control">
	 <small>SKU must be unique.</small><br>
     Quantity: <input type="number" name="gg[{{$rnd}}][quantity]" class="form-control"><br>

        </div>
<?php
       
		$rnd++;
		
        // after print current combination now moving for next combiation if it have.
		$next=$n-1;
		
		while($next>=0 && (($temp[$next]+1)>=count($final[$next]))){
			$next--;
		}
       // no array  element found 
        
		if($next<0){
			
			return;
		}
		 //if next element occur in array
	    $temp[$next]++;
	 
        // current index again points to   first element
        
		for($i=$next+1;$i<$n;$i++){
			$temp[$i]=0;
		}
      
	echo "<br>";
	?>
	@endwhile








	


