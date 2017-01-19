@if( isset( $categories ) )

@foreach( $categories as $item )

<tr>
	<td  style="padding-left: {{ $item['depth'] * 20 }}px; " >{{ $item['title'] }}</td>
	<td ><a href="/?pid={{ $item["id"] }}">Create child</a></td>
</tr>

@endforeach

@endif
