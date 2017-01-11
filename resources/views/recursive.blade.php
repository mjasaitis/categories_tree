@if( isset( $categories[$pid] ) )

@foreach( $categories[$pid] as $item )

<tr>
	<td  style="padding-left: {{ $level * 20 }}px; " >{{ $item['title'] }}</td>
	<td ><a href="/?pid={{ $item["id"] }}">Create child</a></td>
	@include("recursive", array("pid" => $item['id'], "level" => $level+1 )  )
</tr>

@endforeach


@endif
