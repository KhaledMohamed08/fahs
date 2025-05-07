<div class="btn-group d-flex gap-2" role="group">
    <a title="show" href="{{ route('assessments.show', $assessment->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></i></a>
    <form title="delete" action="{{ route('assessments.destroy', $assessment->id) }}" method="POST"
        onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
        <button type="submit" id="submitBtn" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
    </form>
</div>