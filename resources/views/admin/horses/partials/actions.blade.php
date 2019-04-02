<div class="btn-group">
	<a 
		class="btn btn-secondary"
		href="{{route('admin.horses.edit', ['id' => $horse->id])}}"
		title="edit"
	><i class="fa fa-pencil"></i></a>

	<button 
		class="btn btn-secondary" 
		title="delete" 
		data-action="delete"
		data-id="{{$horse->id}}"
	>
		<i class="fa fa-trash"></i>
	</button>
</div>