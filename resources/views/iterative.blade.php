@if( isset( $categories_i ) )

@foreach( $categories_i as $item )

<tr>
	<td  style="padding-left: {{ $item['level'] * 20 }}px; " >{{ $item['title'] }}</td>
	<td ><a href="/?pid={{ $item["id"] }}">Create child</a></td>
</tr>

@endforeach

@endif
