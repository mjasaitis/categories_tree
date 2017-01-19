@if( isset( $node->children ) )

@foreach( $node->children as $item )
	<tr>
		<td  style="padding-left: {{ $level * 20 }}px; " >{{ $item->data->title }}</td>
		<td ><a href="/?pid={{ $item->data->id }}">Create child</a></td>
	</tr>
	@include("recursive", array("node" => $item, "level" => $level+1 )  )
@endforeach

@endif